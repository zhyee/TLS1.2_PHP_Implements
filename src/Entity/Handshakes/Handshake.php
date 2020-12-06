<?php
namespace TLS\Entity\Handshakes;

use TLS\Contracts\Resolvable;
use TLS\Contracts\StringAble;
use TLS\Entity\Records\Alert;
use TLS\Entity\Records\Record;
use TLS\Entity\Records\TLSPlaintextRecord;
use TLS\Exceptions\AlertException;
use TLS\Exceptions\ResolveException;
use TLS\Exceptions\SocketIOException;
use TLS\Library\SocketIO;

class Handshake implements StringAble,Resolvable
{
    const HANDSHAKE_TYPE_HELLO_REQUEST = 0;
    const HANDSHAKE_TYPE_CLIENT_HELLO = 1;
    const HANDSHAKE_TYPE_SERVER_HELLO = 2;
    const HANDSHAKE_TYPE_CERTIFICATE = 11;
    const HANDSHAKE_TYPE_SERVER_KEY_EXCHANGE = 12;
    const HANDSHAKE_TYPE_CERTIFICATE_REQUEST = 13;
    const HANDSHAKE_TYPE_SERVER_HELLO_DONE = 14;
    const HANDSHAKE_TYPE_CERTIFICATE_VERIFY = 15;
    const HANDSHAKE_TYPE_CLIENT_KEY_EXCHANGE = 16;
    const HANDSHAKE_TYPE_FINISHED = 20;

    const HEAD_LENGTH = 4;

    public $handshakeType;

    public $body;

    /**
     * HandshakeFragment constructor.
     * @param $handshakeType
     * @param string|StringAble $body
     */
    public function __construct($handshakeType, $body)
    {
        $this->handshakeType = $handshakeType;
        $this->body = $body;
    }

    /**
     * @return false|string
     */
    public function toByteString()
    {
        $body = $this->body;
        if ($body instanceof StringAble) {
            $body = $body->toByteString();
        }
        $stream = pack('C', $this->handshakeType);
        $bodyLength = strlen($body);
        $stream .= pack('CCC', ($bodyLength >> 16) & 0xff, ($bodyLength >> 8) & 0xff, $bodyLength & 0xff);
        $stream .= $body;
        return $stream;
    }

    /**
     * @param SocketIO $socket
     * @return self
     * @throws ResolveException
     * @throws SocketIOException
     * @throws AlertException
     */
    public static function resolveFromSocket($socket)
    {
        $record = TLSPlaintextRecord::ResolveFromSocket($socket);

        if ($record->contentType != Record::CONTENT_TYPE_HANDSHAKE) {
            if ($record->contentType == Record::CONTENT_TYPE_ALERT && $record->body instanceof Alert) {
                /** @var Alert $alert */
                $alert = $record->body;
                $alert->throwsException();
            }
            throw new ResolveException('record不是handshake类型： ' . $record->contentType);
        }

        $handshakeStr = $record->body;

        $pos = 0;
        $handshakeType = ord($handshakeStr[$pos++]);
        $handshakeBodyLen = (ord($handshakeStr[$pos++]) << 16) | (ord($handshakeStr[$pos++]) << 8) | ord($handshakeStr[$pos++]);
        if (strlen($handshakeStr) - $pos >= $handshakeBodyLen) {
            $bodyString = substr($handshakeStr, $pos, $handshakeBodyLen);
        } else {
            $bodyString = substr($handshakeStr, $pos);
            $needBodyLength = strlen($handshakeBodyLen) - strlen($handshakeStr) + $pos;
            while ($needBodyLength > 0) {
                $record = TLSPlaintextRecord::ResolveFromSocket($socket);
                $recordBodyLen = strlen($record->body);
                var_dump($recordBodyLen);
                var_dump($needBodyLength);
                if ($recordBodyLen >= $needBodyLength) {
                    $bodyString .= substr($record->body, 0, $needBodyLength);
                    break;
                } else {
                    $bodyString .= $record->body;
                    $needBodyLength -= $recordBodyLen;
                }
            }
        }
        switch ($handshakeType) {
            case self::HANDSHAKE_TYPE_CLIENT_HELLO:
                $body = ClientHello::resolveFromString($bodyString);
                break;
            case self::HANDSHAKE_TYPE_SERVER_HELLO:
                $body = ServerHello::resolveFromString($bodyString);
                break;
            case self::HANDSHAKE_TYPE_CERTIFICATE:
                $body = ServerCertificate::resolveFromString($bodyString);
                break;
            default:
                throw new ResolveException('不支持的握手类型: ' . $handshakeType);
                break;
        }
        return new self($handshakeType, $body);
    }

    /**
     * 从字节流中解析出本实体body的长度
     * @param $string
     * @return int
     */
    public static function resolveBodyLenFromString($string)
    {
        return (ord($string[1]) << 16) | (ord($string[2]) << 8) | ord($string[3]);
    }

    /**
     * 从字节流中解析出相应实体
     * @param string $string
     * @return self
     */
    public static function resolveFromString(&$string)
    {
        // TODO: Implement resolveFromString() method.
    }
}
