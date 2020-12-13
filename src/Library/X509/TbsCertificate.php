<?php
namespace TLS\Library\X509;

class TbsCertificate
{
    public $version;

    public $serialNumber;

    public $signature;

    public $issuer;

    public $validity;

    public $subject;

    public $subjectPublicKeyInfo;

    public $issuerUniqueID;

    public $subjectUniqueID;

    public $extensions;
}
