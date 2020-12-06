<?php
namespace TLS\Entity\Records;

use TLS\Contracts\Resolvable;
use TLS\Contracts\StringAble;
use TLS\Entity\Handshakes\Handshake;
use TLS\Exceptions\ResolveException;
use TLS\Exceptions\SocketIOException;
use TLS\Library\SocketIO;

class TLSPlaintextRecord extends Record implements StringAble,Resolvable
{
    /**
     * TLSPlainRecord的消息头长度固定为5个字节
     */
    const HEAD_LENGTH = 5;

    /**
     * TLSPlaintextRecord constructor.
     * @param int $contentType
     * @param int $TLSMajorVersion
     * @param int $TLSMinorVersion
     * @param string|StringAble $body
     */
    public function __construct($contentType, $TLSMajorVersion, $TLSMinorVersion, $body)
    {
        $this->contentType = $contentType;
        $this->TLSMajorVersion = $TLSMajorVersion;
        $this->TLSMinorVersion = $TLSMinorVersion;
        $this->body = $body;
    }

    public function toByteString()
    {
        $fragment = $this->body;
        if ($fragment instanceof StringAble) {
            $fragment = $fragment->toByteString();
        }

        // 每个TLSPlainRecord的最大长度为 2 ^ 14, 切割成多个record来发送;
        $fragmentPieces = str_split($fragment, 1 << 14);
        $record = '';
        foreach ($fragmentPieces as $piece) {
            $record .= pack('C', $this->contentType);
            $record .= pack('CC', $this->TLSMajorVersion, $this->TLSMinorVersion);
            $record .= pack('n', strlen($piece));
            $record .= $piece;
        }
        return $record;
    }


    /**
     * @param string $string
     * @return self
     * @throws ResolveException
     * @throws SocketIOException
     */
    public static function resolveFromString(&$string)
    {
        $pos = 0;
        $contentType = ord($string[$pos++]);
        $TLSMajorVersion = ord($string[$pos++]);
        $TLSMinorVersion = ord($string[$pos++]);
        $fragmentLength = (ord($string[$pos++]) << 8) | ord($string[$pos++]);
        $fragmentString = substr($string, $pos, $fragmentLength);
        switch ($contentType) {
            case self::CONTENT_TYPE_ALERT:
                $body = Alert::resolveFromString($fragmentString);
                break;
            case self::CONTENT_TYPE_HANDSHAKE:
                $body = Handshake::resolveFromString($fragmentString);
                break;
            default:
                throw new ResolveException('不支持的TLSPlainRecord类型：' . $contentType);
                break;

        }
        return new self($contentType, $TLSMajorVersion, $TLSMinorVersion, $body);
    }

    /**
     * @param SocketIO $socket
     * @return TLSPlaintextRecord
     * @throws SocketIOException
     */
    public static function ResolveFromSocket($socket)
    {
        $recordHeadStr = $socket->bufferedRead(self::HEAD_LENGTH);
        $pos = 0;
        $contentType = ord($recordHeadStr[$pos++]);
        $TLSMajorVersion = ord($recordHeadStr[$pos++]);
        $TLSMinorVersion = ord($recordHeadStr[$pos++]);
        $bodyLength = (ord($recordHeadStr[$pos++]) << 8) | ord($recordHeadStr[$pos++]);
        $bodyString = $socket->bufferedRead($bodyLength);
        return new self($contentType, $TLSMajorVersion, $TLSMinorVersion, $bodyString);
    }

    /**
     * 从字节流中解析出本实体body的长度
     * @param $string
     * @return int
     */
    public static function resolveBodyLenFromString($string)
    {
        return (ord($string[3]) << 8) | ord($string[4]);
    }
}
