<?php
namespace TLS\Entity\Handshakes;

use TLS\Contracts\Resolvable;
use TLS\Contracts\StringAble;
use TLS\Exceptions\ResolveException;
use TLS\Library\SocketIO;

/**
 * Server_Name extension
 * Class ServerNameHelloExtension
 * @see https://tools.ietf.org/html/rfc6066
 */
class HelloExtensionServerName implements StringAble,Resolvable
{
    const TYPE_HOST_NAME = 0;

    public $nameList = [];

    public function addTypeAndName($type, $name)
    {
        $this->nameList[$type] = $name;
    }

    public function toByteString()
    {
        $nameListStr = '';
        foreach ($this->nameList as $type => $name) {
            $nameListStr = pack('C', $type);
            $nameListStr .= pack('n', strlen($name));
            $nameListStr .= $name;
        }
        return pack('n', strlen($nameListStr)) . $nameListStr;
    }

    /**
     * @param string $string
     * @return self
     * @throws ResolveException
     */
    public static function resolveFromString(&$string)
    {
        $pos = 0;
        $strLen = strlen($string);
        $totalLen = (ord($string[$pos++]) << 8) | ord($string[$pos++]);
        if ($totalLen != $strLen - 2) {
            throw new ResolveException(self::class . ' 提供的字符串长度和解析长度不匹配');
        }
        $instance = new self();
        while ($pos < $strLen) {
            $type = ord($string[$pos++]);
            $nameLen = (ord($string[$pos++]) << 8) | ord($string[$pos++]);
            $name = substr($string, $pos, $nameLen);
            $pos += $nameLen;
            $instance->addTypeAndName($type, $name);
        }
        return $instance;
    }

    /**
     * 从Socket中解析出相应实体
     * @param SocketIO $socket
     * @return self
     */
    public static function resolveFromSocket($socket)
    {
        // TODO: Implement resolveFromSocket() method.
    }
}
