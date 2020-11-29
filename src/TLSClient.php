<?php

namespace TLS;

use TLS\Entity\Handshakes\ClientHello;
use TLS\Entity\Handshakes\HandshakeFragment;
use TLS\Entity\Handshakes\HelloExtension;
use TLS\Entity\Handshakes\HelloExtensionServerName;
use TLS\Entity\Handshakes\ServerHello;
use TLS\Entity\Records\Alert;
use TLS\Entity\Records\Record;
use TLS\Entity\Records\RecordHead;
use TLS\Entity\Records\TLSPlaintextRecord;
use TLS\Exceptions\FragmentException;
use TLS\Exceptions\SocketException;
use TLS\Library\SocketIO;


class TLSClient extends SocketIO
{
    public $host;
    public $port;

    protected $clientRandomStr;

    protected $serverRandomStr;

    protected $cipherSuite;

    protected $compressionMethod;

    /**
     * TLSClient constructor.
     * @param $host
     * @param $port
     * @throws \Exception
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            $errCode = socket_last_error();
            throw new SocketException('创建socket失败：' . socket_strerror($errCode), $errCode);
        }
        if (!socket_connect($socket, $this->host, $this->port)) {
            $errCode = socket_last_error();
            throw new SocketException('连接服务器失败：' . socket_strerror($errCode), $errCode);
        }
        $this->socket = $socket;
        $this->handshake();
    }

    /**
     * @throws \Exception
     */
    private function handshake()
    {
        $this->sendClientHello();
        $this->recvServerHello();
    }

    /**
     * @throws \Exception
     */
    private function sendClientHello()
    {
        $randomStr = pack('N', time()) . random_bytes(28);  // 32字节的随机数

        $cipherSuiteArr = [
            [0, 0x2f], // TLS_RSA_WITH_AES_128_CBC_SHA
            [0, 0x35], // TLS_RSA_WITH_AES_256_CBC_SHA
            [0, 0x3c], // TLS_RSA_WITH_AES_128_CBC_SHA256
            [0, 0x3d], // TLS_RSA_WITH_AES_256_CBC_SHA256
        ];

        $extensionArr = [];
        $extension = new HelloExtension(HelloExtension::TYPE_SERVER_NAME, new HelloExtensionServerName('101.200.35.175'));
        $extensionArr[] = $extension;

        $clientHello = new ClientHello(
            3,3, $randomStr, null, $cipherSuiteArr, [0], $extensionArr
        );

        $handshakeFragment = new HandshakeFragment(HandshakeFragment::HANDSHAKE_TYPE_CLIENT_HELLO, $clientHello);


        $record = new TLSPlaintextRecord(Record::CONTENT_TYPE_HANDSHAKE, 3, 3, $handshakeFragment);
        $record = $record->toByteStream();
        $this->writeN($record, strlen($record));
        $this->clientRandomStr = $randomStr;
    }

    /**
     * @return HandshakeFragment
     * @throws Exceptions\AlertException
     * @throws Exceptions\SocketIOException
     * @throws FragmentException
     */
    private function recvServerHello()
    {
        $recordHead = new RecordHead($this->bufferedRead(5));

        var_dump($recordHead);

        switch ($recordHead->contentType) {
            case Record::CONTENT_TYPE_ALERT:
                if ($recordHead->fragmentLength != 2) {
                    throw new FragmentException('Alert消息解析错误');
                }
                $alertChars = $this->bufferedRead($recordHead->fragmentLength);
                $alert = new Alert(ord($alertChars[0]), ord($alertChars[1]));
                $alert->throwsException();
                break;
            case Record::CONTENT_TYPE_HANDSHAKE:
                $handShake = HandshakeFragment::makeFromBytes($this->bufferedRead($recordHead->fragmentLength));
                if ($handShake->handshakeType == HandshakeFragment::HANDSHAKE_TYPE_SERVER_HELLO) {
                    $serverHello = $handShake->body;
                    if ($serverHello instanceof ServerHello) {
                        $this->serverRandomStr = $serverHello->randomStr;
                        $this->cipherSuite = $serverHello->cipherSuite;
                        $this->compressionMethod = $serverHello->compressionMethod;
                    }
                }
                return $handShake;
                break;
        }
    }
}




