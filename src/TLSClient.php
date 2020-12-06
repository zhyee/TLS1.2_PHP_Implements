<?php

namespace TLS;

use Exception;
use TLS\Entity\Algorithms\CipherSuite;
use TLS\Entity\Handshakes\ClientHello;
use TLS\Entity\Handshakes\Handshake;
use TLS\Entity\Handshakes\HelloExtension;
use TLS\Entity\Handshakes\HelloExtensionServerName;
use TLS\Entity\Handshakes\ServerCertificate;
use TLS\Entity\Handshakes\ServerHello;
use TLS\Entity\Records\Alert;
use TLS\Entity\Records\Record;
use TLS\Entity\Records\RecordHead;
use TLS\Entity\Records\TLSPlaintextRecord;
use TLS\Exceptions\FragmentException;
use TLS\Exceptions\ResolveException;
use TLS\Exceptions\SocketException;
use TLS\Library\SocketIO;


class TLSClient extends SocketIO
{
    public $host;
    public $port;

    protected $clientRandomStr;

    protected $serverRandomStr;

    /**
     * @var CipherSuite
     */
    protected $cipherSuite;

    protected $compressionMethod;

    /**
     * TLSClient constructor.
     * @param $host
     * @param $port
     * @throws Exception
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
        $this->setSocket($socket);
        $this->handshake();
    }

    /**
     * @throws Exception
     */
    private function handshake()
    {
        $this->sendClientHello();
        $this->recvServerHello();
        $this->recvServerCertificate();
    }

    /**
     * @throws Exception
     */
    private function sendClientHello()
    {
        $randomStr = pack('N', time()) . random_bytes(28);  // 32字节的随机数

        $cipherSuiteArr = [
            CipherSuite::TLS_RSA_WITH_AES_128_CBC_SHA,
            CipherSuite::TLS_RSA_WITH_AES_256_CBC_SHA,
            CipherSuite::TLS_RSA_WITH_AES_128_CBC_SHA256,
            CipherSuite::TLS_RSA_WITH_AES_256_CBC_SHA256,
        ];

        $extensionArr = [];
        $extServerName = new HelloExtensionServerName();
        $extServerName->addTypeAndName(HelloExtensionServerName::TYPE_HOST_NAME, '101.200.35.175');
        $extension = new HelloExtension(HelloExtension::TYPE_SERVER_NAME, $extServerName);
        $extensionArr[] = $extension;

        $clientHello = new ClientHello(
            3,3, $randomStr, null, $cipherSuiteArr, [0], $extensionArr
        );

        $handshakeFragment = new Handshake(Handshake::HANDSHAKE_TYPE_CLIENT_HELLO, $clientHello);

        $record = new TLSPlaintextRecord(Record::CONTENT_TYPE_HANDSHAKE, 3, 3, $handshakeFragment);

        $record = $record->toByteString();
        $this->writeN($record, strlen($record));
        $this->clientRandomStr = $randomStr;
    }

    /**
     * @return ServerHello
     * @throws Exceptions\SocketIOException
     * @throws ResolveException
     * @throws Exceptions\AlertException
     */
    private function recvServerHello()
    {
        $handShake = Handshake::resolveFromSocket($this);
        if ($handShake->handshakeType != Handshake::HANDSHAKE_TYPE_SERVER_HELLO) {
            throw new ResolveException('不正确的handshake类型：' . $handShake->handshakeType);
        }

        /** @var ServerHello $serverHello */
        $serverHello = $handShake->body;

        $this->serverRandomStr = $serverHello->randomStr;
        $this->cipherSuite = $serverHello->cipherSuite;
        $this->compressionMethod = $serverHello->compressionMethod;
        return $serverHello;
    }

    /**
     * @throws Exceptions\AlertException
     * @throws Exceptions\SocketIOException
     * @throws ResolveException
     */
    protected function recvServerCertificate()
    {
        $handShake = Handshake::resolveFromSocket($this);
        if ($handShake->handshakeType != Handshake::HANDSHAKE_TYPE_CERTIFICATE) {
            throw new ResolveException('不正确的handshake类型：' . $handShake->handshakeType);
        }
        /** @var ServerCertificate $serverCert */
        $serverCert = $handShake->body;
        foreach ($serverCert->certificateList as $cert) {
            for($i = 0; $i < strlen($cert); $i++) {
                echo '\x' . dechex(ord($cert[$i]));
            }
            echo PHP_EOL;
        }
    }
}




