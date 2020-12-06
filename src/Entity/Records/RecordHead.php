<?php
namespace TLS\Entity\Records;

use TLS\Exceptions\SocketIOException;

class RecordHead extends Record
{

    /**
     * RecordHead constructor.
     * @param $headChars
     * @throws SocketIOException
     */
    public function __construct($headChars)
    {
        if (strlen($headChars) != 5) {
            throw new SocketIOException('消息头格式错误');
        }
        $this->contentType = ord($headChars[0]);
        $this->TLSMajorVersion = ord($headChars[1]);
        $this->TLSMinorVersion = ord($headChars[2]);
        $this->bodyLength = (ord($headChars[3]) << 8) + ord($headChars[4]);
    }
}