<?php

use TLS\Library\ASN1\ASN1Resolver;
use TLS\TLSClient;

require __DIR__ . "/../vendor/autoload.php";

//$tlsClient = new TLSClient('101.200.35.175', 443);


print_r(ASN1Resolver::loadFromText(file_get_contents(__DIR__ . '/ssl.der')));