<?php
namespace TLS\Contracts;

use TLS\Library\SocketIO;

interface Resolvable
{
    /**
     * 从字节流中解析出相应实体
     * @param string $string
     * @return self
     */
    public static function resolveFromString(&$string);

    /**
     * 从Socket中解析出相应实体
     * @param SocketIO $socket
     * @return self
     */
    public static function resolveFromSocket($socket);

}
