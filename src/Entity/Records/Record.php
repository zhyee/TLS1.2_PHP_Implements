<?php
namespace TLS\Entity\Records;

use TLS\Library\SocketIO;

class Record extends SocketIO
{
    const CONTENT_TYPE_CHANGE_CIPHER_SPEC = 20;

    const CONTENT_TYPE_ALERT = 21;

    const CONTENT_TYPE_HANDSHAKE = 22;

    const CONTENT_TYPE_APPLICATION_DATA = 23;

    public $contentType;
    public $TLSMajorVersion;
    public $TLSMinorVersion;
    public $body;
    public $bodyLength;

}
