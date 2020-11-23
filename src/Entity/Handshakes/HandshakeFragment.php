<?php
namespace TLS\Entity\Handshakes;

use TLS\Contract\Serializable;

class HandshakeFragment implements Serializable
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

    public $handshakeType;

    public $body;

    /**
     * HandshakeFragment constructor.
     * @param $handshakeType
     * @param Serializable $body
     */
    public function __construct($handshakeType, Serializable $body)
    {
        $this->handshakeType = $handshakeType;
        $this->body = $body;
    }

    public function toByteStream()
    {
        $body = $this->body;
        if ($body instanceof Serializable) {
            $body = $body->toByteStream();
        }
        $stream = pack('C', $this->handshakeType);
        $bodyLength = strlen($body);
        $stream .= pack('CCC', ($bodyLength >> 16) & 0xff, ($bodyLength >> 8) & 0xff, $bodyLength & 0xff);
        $stream .= $body;
        echo 'Handshakes: ' . strlen($stream) . PHP_EOL;
        for ($i = 0; $i < strlen($stream); $i++) {
            echo '\x' . dechex(ord($stream[$i]));
        }
        echo PHP_EOL;
        return $stream;
    }
}