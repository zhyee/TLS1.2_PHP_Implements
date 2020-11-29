<?php
namespace TLS\Entity\Handshakes;

abstract class BaseHello
{
    public $TLSMajorVersion;
    public $TLSMinorVersion;
    public $unixTimestamp;
    public $randomStr;
    public $sessionId;
    public $extensionArr;
}
