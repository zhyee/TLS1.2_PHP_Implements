<?php

namespace TLS\Library\X509;

use TLS\Library\ASN1\ASN1Resolver;

class X509Certificate
{
    public $tbsCertificate;

    public $signatureAlgorithm;

    public $signatureValue;

    public function __construct(TbsCertificate $tbsCertificate, SignatureAlgorithm $signatureAlgorithm, $signatureValue)
    {
        $this->tbsCertificate = $tbsCertificate;
        $this->signatureAlgorithm = $signatureAlgorithm;
        $this->signatureValue = $signatureValue;
    }

    public function loadFromText($text)
    {
        $asn1 = ASN1Resolver::loadFromText($text);
    }
}

