<?php
namespace TLS\Entity\Records;

class Record
{
    const CONTENT_TYPE_CHANGE_CIPHER_SPEC = 20;

    const CONTENT_TYPE_ALERT = 21;

    const CONTENT_TYPE_HANDSHAKE = 22;

    const CONTENT_TYPE_APPLICATION_DATA = 23;

    public $contentType;
    public $TLSMajorVersion;
    public $TLSMinorVersion;
    public $fragment;
    public $fragmentLength;

}
