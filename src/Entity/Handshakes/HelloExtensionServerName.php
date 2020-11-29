<?php
namespace TLS\Entity\Handshakes;

use TLS\Contract\Serializable;

/**
 * Server_Name extension
 * Class ServerNameHelloExtension
 * @see https://tools.ietf.org/html/rfc6066
 */
class HelloExtensionServerName implements Serializable
{
    const TYPE_HOST_NAME = 0;

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function toByteStream()
    {
        $nameList = pack('C', self::TYPE_HOST_NAME);
        $nameList .= pack('n', strlen($this->name));
        $nameList .= $this->name;
        return pack('n', strlen($nameList)) . $nameList;
    }

    public static function makeFromBytes($chars)
    {
        $pos = 0;
        $totalLen = (ord($chars[$pos++]) << 8) | ord($chars[$pos++]);
        $type = ord($chars[$pos++]);
        $nameLen = (ord($chars[$pos++]) << 8) | ord($chars[$pos++]);
        $name = substr($chars, $pos, $nameLen);
        return new self($name);
    }
}
