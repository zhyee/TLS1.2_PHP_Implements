<?php
namespace TLS\Entity\Handshakes;

use TLS\Contracts\Resolvable;
use TLS\Contracts\StringAble;
use TLS\Entity\Algorithms\CipherSuite;
use TLS\Exceptions\ResolveException;
use TLS\Exceptions\SocketIOException;
use TLS\Library\SocketIO;

class ServerHello extends BaseHello implements StringAble,Resolvable
{

    /**
     * @var CipherSuite
     */
    public $cipherSuite;

    public $compressionMethod;


    /**
     * @param string $string
     * @return Resolvable|ServerHello
     * @throws ResolveException
     */
    public static function resolveFromString(&$string)
    {
        $pos = 0;
        $instance = new ServerHello();
        $instance->TLSMajorVersion = ord($string[$pos++]);
        $instance->TLSMinorVersion = ord($string[$pos++]);

        $instance->randomStr = substr($string, $pos, 32);
        $pos += 32;

        $instance->unixTimestamp = (ord($instance->randomStr[0]) << 24)
            | (ord($instance->randomStr[1]) << 16)
            | (ord($instance->randomStr[2]) << 8)
            | ord($instance->randomStr[3]);

        $sessionIdLen = ord($string[$pos++]);
        if ($sessionIdLen > 0) {
            $instance->sessionId = substr($string, $pos, $sessionIdLen);
            $pos += $sessionIdLen;
        } else {
            $instance->sessionId = '';
        }

        $instance->cipherSuite = new CipherSuite(ord($string[$pos++]), ord($string[$pos++]));

        $instance->compressionMethod = ord($string[$pos++]);

        $length = strlen($string);

        if ($length > $pos) {
            $extensionLen = (ord($string[$pos++]) << 8) | ord($string[$pos++]);
            $extensionChars = substr($string, $pos, $extensionLen);

            while (strlen($extensionChars) > 0) {
                $instance->extensionArr[] = HelloExtension::resolveFromSocket($extensionChars);
            }
        }

        return $instance;
    }

    /**
     * @param SocketIO $socket
     * @return void
     */
    public static function resolveFromSocket($socket)
    {
        // TODO: Implement resolveFromSocket() method.
    }

    public function toByteString()
    {
        // TODO: Implement toByteStream() method.
    }
}