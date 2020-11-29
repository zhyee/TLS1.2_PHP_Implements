<?php
namespace TLS\Entity\Handshakes;

use TLS\Contract\Serializable;

class ServerHello extends BaseHello implements Serializable
{
    /**
     * @var array
     */
    public $cipherSuite;

    public $compressionMethod;

    public static function makeFromBytes($fragmentChars)
    {

        $pos = 0;
        $instance = new ServerHello();
        $instance->TLSMajorVersion = ord($fragmentChars[$pos++]);
        $instance->TLSMinorVersion = ord($fragmentChars[$pos++]);

        $instance->randomStr = substr($fragmentChars, $pos, 32);
        $pos += 32;

        $instance->unixTimestamp = (ord($instance->randomStr[0]) << 24)
            | (ord($instance->randomStr[1]) << 16)
            | (ord($instance->randomStr[2]) << 8)
            | ord($instance->randomStr[3]);

        $sessionIdLen = ord($fragmentChars[$pos++]);
        if ($sessionIdLen > 0) {
            $instance->sessionId = substr($fragmentChars, $pos, $sessionIdLen);
            $pos += $sessionIdLen;
        } else {
            $instance->sessionId = '';
        }

        $instance->cipherSuite = [ord($fragmentChars[$pos++]), ord($fragmentChars[$pos++])];

        $instance->compressionMethod = ord($fragmentChars[$pos++]);

        $length = strlen($fragmentChars);

        if ($length > $pos) {
            $extensionLen = (ord($fragmentChars[$pos++]) << 8) | ord($fragmentChars[$pos++]);
            $extensionChars = substr($fragmentChars, $pos, $extensionLen);
            $pos += $extensionLen;

            while (strlen($extensionChars) > 0) {
                $instance->extensionArr[] = HelloExtension::makeFromBytes($extensionChars);
            }
        }

        return $instance;
    }

    public function toByteStream()
    {
        // TODO: Implement toByteStream() method.
    }

}