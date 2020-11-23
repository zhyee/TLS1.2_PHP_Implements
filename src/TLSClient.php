<?php

namespace TLS;

use TLS\Entity\Handshakes\ClientHello;
use TLS\Entity\Handshakes\HandshakeFragment;
use TLS\Entity\Handshakes\HelloExtension;
use TLS\Entity\Handshakes\HelloExtensionServerName;
use TLS\Entity\Records\Record;
use TLS\Entity\Records\TLSPlaintextRecord;
use TLS\Exceptions\SocketException;


class TLSClient
{
    public $host;
    public $port;

    /**
     * 连接服务器的socket
     * @var resource
     */
    public $socket;

    /**
     * TLSClient constructor.
     * @param $host
     * @param $port
     * @throws SocketException
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
     * @param $str
     * @param $len
     * @throws SocketException
     */
    private function writeN($str, $len)
    {
        $writeLen = 0;
        do {
            $n = socket_write($this->socket, $str, $len - $writeLen);
            if ($n === false) {
                $errCode = socket_last_error();
                throw new SocketException('发送数据失败：' . socket_strerror($errCode), $errCode);
            }
            $writeLen += $n;
            if ($writeLen >= $len) {
                break;
            }
            if ($n > 0) {
                $str = substr($str, $n);
            }
        } while (true);
    }

    /**
     * @throws SocketException
     */
    private function handshake()
    {
        $this->sendClientHello();
        $this->recvServerHello();
    }

    /**
     * @throws SocketException
     */
    private function sendClientHello()
    {
        $randomStr = substr(md5(uniqid()), 0, 28);

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
            3,3, time(), $randomStr, null,
            $cipherSuiteArr, [0], $extensionArr
        );

        $handshakeFragment = new HandshakeFragment(HandshakeFragment::HANDSHAKE_TYPE_CLIENT_HELLO, $clientHello);


        $record = new TLSPlaintextRecord(Record::CONTENT_TYPE_HANDSHAKE, 3, 3, $handshakeFragment);
        $record = $record->toByteStream();
        $this->writeN($record, strlen($record));
    }

    private function recvServerHello()
    {
        $res = socket_read($this->socket, 8192);

        for($i = 0; $i < strlen($res); $i++) {
            echo '\\x' . dechex(ord($res[$i]));
        }
    }
}


//$fp = fopen('/dev/urandom', 'r');
//$randomStr = fread($fp, 28);
//fclose($fp);

$tlsClient = new TLSClient('101.200.35.175', 443);





echo '------------------------------------' . PHP_EOL;


