<?php
namespace TLS\Entity\Handshakes;

use ErrorException;
use TLS\Contracts\Resolvable;
use TLS\Exceptions\ResolveException;
use TLS\Library\SocketIO;

class ServerCertificate implements Resolvable
{

    public $certificateList = [];

    public function addCertificate($certificate)
    {
        $this->certificateList[] = $certificate;
    }

    /**
     * @param $string
     * @return self
     * @throws ResolveException
     */
    public static function resolveFromString(&$string)
    {
        $pos = 0;
        $factLen = strlen($string);
        $needLen = (ord($string[$pos++]) << 16) | (ord($string[$pos++]) << 8) | ord($string[$pos++]);
        if ($factLen - 3 < $needLen) {
            throw new ResolveException(self::class . ' 提供的字节流长度与解析长度不匹配');
        }
        $instance = new self();
        while ($pos < $factLen) {
            $certLen = (ord($string[$pos++]) << 16) | (ord($string[$pos++]) << 8) | ord($string[$pos++]);
            $cert = substr($string, $pos, $certLen);
            $instance->addCertificate($cert);
            $pos += $certLen;
        }
        return $instance;
    }

    /**
     * 从Socket中解析出相应实体
     * @param SocketIO $socket
     * @return void
     * @throws ErrorException
     */
    public static function resolveFromSocket($socket)
    {
        throw new ErrorException('not implement');
    }
}