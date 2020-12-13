<?php
namespace TLS\Library\ASN1;

class ASN1Type
{
    const TAG_CLASS_UNIVERSAL = 0;
    const TAG_CLASS_APPLICATION = 1;
    const TAG_CLASS_CONTEXT_SPECIFIC = 2;
    const TAG_CLASS_PRIVATE = 3;

    const TAG_BOOLEAN = 1;
    const TAG_INTEGER = 2;
    const TAG_BIT_STRING = 3;
    const TAG_OCTET_STRING = 4;
    const TAG_NULL = 5;
    const TAG_OBJECT_IDENTIFIER = 6;
    const TAG_OBJECT_DESCRIPTION = 7;
    const TAG_EXTERNAL = 8;
    const TAG_REAL = 9;
    const TAG_ENUMERATED = 10;
    const TAG_EMBEDDED_PDV = 11;
    const TAG_UTF8_STRING = 12;
    const TAG_RELATIVE_OID = 13;
    const TAG_SEQUENCE = 16;
    const TAG_SET = 17;
    const TAG_NUMERIC_STRING = 18;
    const TAG_PRINTABLE_STRING = 19;
    const TAG_T61_STRING = 20;
    const TAG_Videotex_STRING = 21;
    const TAG_IA5_STRING = 22;
    const TAG_UTC_TIME = 23;
    const TAG_GENERALIZED_TIME = 24;
    const TAG_GRAPHIC_STRING = 25;
    const TAG_ISO646_STRING = 26;
    const TAG_GENERAL_STRING = 27;
    const TAG_UNIVERSAL_STRING = 28;
    const TAG_CHARACTER_STRING = 29;
    const TAG_BMP_STRING = 30;


    const TAG_NAMES = [
        self::TAG_BOOLEAN => 'bool',
        self::TAG_INTEGER => 'int',
        self::TAG_BIT_STRING => 'bit string',
        self::TAG_OCTET_STRING => 'octet string',
        self::TAG_NULL => 'null',
        self::TAG_OBJECT_IDENTIFIER => 'OID',
        self::TAG_OBJECT_DESCRIPTION => 'OID description',
        self::TAG_EXTERNAL => 'external',
        self::TAG_REAL => 'real',
        self::TAG_ENUMERATED => 'enum',
        self::TAG_EMBEDDED_PDV => 'embedded padding',
        self::TAG_UTF8_STRING => 'utf8 string',
        self::TAG_RELATIVE_OID => 13,
        self::TAG_SEQUENCE => 'sequence',
        self::TAG_SET => 'set',
        self::TAG_NUMERIC_STRING => 18,
        self::TAG_PRINTABLE_STRING => 'printable string',
        self::TAG_T61_STRING => 20,
        self::TAG_Videotex_STRING => 21,
        self::TAG_IA5_STRING => 'IA5 string',
        self::TAG_UTC_TIME => 'utc time',
        self::TAG_GENERALIZED_TIME => 'generalized time',
        self::TAG_GRAPHIC_STRING => 25,
        self::TAG_ISO646_STRING => 26,
        self::TAG_GENERAL_STRING => 27,
        self::TAG_UNIVERSAL_STRING => 28,
        self::TAG_CHARACTER_STRING => 29,
        self::TAG_BMP_STRING => 30,
    ];

    // oid maps
    const OBJECT_IDENTIFIERS = [
        '1.3.6.1.5.5.7' => 'id-pkix',
        '1.3.6.1.5.5.7.1' => 'id-pe',
        '1.3.6.1.5.5.7.2' => 'id-qt',
        '1.3.6.1.5.5.7.3' => 'id-kp',
        '1.3.6.1.5.5.7.48' => 'id-ad',
        '1.3.6.1.5.5.7.2.1' => 'id-qt-cps',
        '1.3.6.1.5.5.7.2.2' => 'id-qt-unotice',
        '1.3.6.1.5.5.7.48.1' =>'id-ad-ocsp',
        '1.3.6.1.5.5.7.48.2' => 'id-ad-caIssuers',
        '1.3.6.1.5.5.7.48.3' => 'id-ad-timeStamping',
        '1.3.6.1.5.5.7.48.5' => 'id-ad-caRepository',
        '2.5.4' => 'id-at',
        '2.5.4.41' => 'id-at-name',
        '2.5.4.4' => 'id-at-surname',
        '2.5.4.42' => 'id-at-givenName',
        '2.5.4.43' => 'id-at-initials',
        '2.5.4.44' => 'id-at-generationQualifier',
        '2.5.4.3' => 'id-at-commonName',
        '2.5.4.7' => 'id-at-localityName',
        '2.5.4.8' => 'id-at-stateOrProvinceName',
        '2.5.4.10' => 'id-at-organizationName',
        '2.5.4.11' => 'id-at-organizationalUnitName',
        '2.5.4.12' => 'id-at-title',
        '2.5.4.13' => 'id-at-description',
        '2.5.4.46' => 'id-at-dnQualifier',
        '2.5.4.6' => 'id-at-countryName',
        '2.5.4.5' => 'id-at-serialNumber',
        '2.5.4.65' => 'id-at-pseudonym',
        '2.5.4.17' => 'id-at-postalCode',
        '2.5.4.9' => 'id-at-streetAddress',
        '2.5.4.45' => 'id-at-uniqueIdentifier',
        '2.5.4.72' => 'id-at-role',
        '2.5.4.16' => 'id-at-postalAddress',

        '0.9.2342.19200300.100.1.25' => 'id-domainComponent',
        '1.2.840.113549.1.9' => 'pkcs-9',
        '1.2.840.113549.1.9.1' => 'pkcs-9-at-emailAddress',
        '2.5.29' => 'id-ce',
        '2.5.29.35' => 'id-ce-authorityKeyIdentifier',
        '2.5.29.14' => 'id-ce-subjectKeyIdentifier',
        '2.5.29.15' => 'id-ce-keyUsage',
        '2.5.29.16' => 'id-ce-privateKeyUsagePeriod',
        '2.5.29.32' => 'id-ce-certificatePolicies',
        '2.5.29.32.0' => 'anyPolicy',

        '2.5.29.33' => 'id-ce-policyMappings',
        '2.5.29.17' => 'id-ce-subjectAltName',
        '2.5.29.18' => 'id-ce-issuerAltName',
        '2.5.29.9' => 'id-ce-subjectDirectoryAttributes',
        '2.5.29.19' => 'id-ce-basicConstraints',
        '2.5.29.30' => 'id-ce-nameConstraints',
        '2.5.29.36' => 'id-ce-policyConstraints',
        '2.5.29.31' => 'id-ce-cRLDistributionPoints',
        '2.5.29.37' => 'id-ce-extKeyUsage',
        '2.5.29.37.0' => 'anyExtendedKeyUsage',
        '1.3.6.1.5.5.7.3.1' => 'id-kp-serverAuth',
        '1.3.6.1.5.5.7.3.2' => 'id-kp-clientAuth',
        '1.3.6.1.5.5.7.3.3' => 'id-kp-codeSigning',
        '1.3.6.1.5.5.7.3.4' => 'id-kp-emailProtection',
        '1.3.6.1.5.5.7.3.8' => 'id-kp-timeStamping',
        '1.3.6.1.5.5.7.3.9' => 'id-kp-OCSPSigning',
        '2.5.29.54' => 'id-ce-inhibitAnyPolicy',
        '2.5.29.46' => 'id-ce-freshestCRL',
        '1.3.6.1.5.5.7.1.1' => 'id-pe-authorityInfoAccess',
        '1.3.6.1.5.5.7.1.11' => 'id-pe-subjectInfoAccess',
        '2.5.29.20' => 'id-ce-cRLNumber',
        '2.5.29.28' => 'id-ce-issuingDistributionPoint',
        '2.5.29.27' => 'id-ce-deltaCRLIndicator',
        '2.5.29.21' => 'id-ce-cRLReasons',
        '2.5.29.29' => 'id-ce-certificateIssuer',
        '2.5.29.23' => 'id-ce-holdInstructionCode',
        '1.2.840.10040.2' => 'holdInstruction',
        '1.2.840.10040.2.1' => 'id-holdinstruction-none',
        '1.2.840.10040.2.2' => 'id-holdinstruction-callissuer',
        '1.2.840.10040.2.3' => 'id-holdinstruction-reject',
        '2.5.29.24' => 'id-ce-invalidityDate',

        '1.2.840.113549.2.2' => 'md2',
        '1.2.840.113549.2.5' => 'md5',
        '1.3.14.3.2.26' => 'id-sha1',
        '1.2.840.10040.4.1' => 'id-dsa',
        '1.2.840.10040.4.3' => 'id-dsa-with-sha1',
        '1.2.840.113549.1.1' => 'pkcs-1',
        '1.2.840.113549.1.1.1' => 'rsaEncryption',
        '1.2.840.113549.1.1.2' => 'md2WithRSAEncryption',
        '1.2.840.113549.1.1.4' => 'md5WithRSAEncryption',
        '1.2.840.113549.1.1.5' => 'sha1WithRSAEncryption',
        '1.2.840.10046.2.1' => 'dhpublicnumber',
        '2.16.840.1.101.2.1.1.22' => 'id-keyExchangeAlgorithm',
        '1.2.840.10045' => 'ansi-X9-62',
        '1.2.840.10045.4' => 'id-ecSigType',
        '1.2.840.10045.4.1' => 'ecdsa-with-SHA1',
        '1.2.840.10045.1' => 'id-fieldType',
        '1.2.840.10045.1.1' => 'prime-field',
        '1.2.840.10045.1.2' => 'characteristic-two-field',
        '1.2.840.10045.1.2.3' => 'id-characteristic-two-basis',
        '1.2.840.10045.1.2.3.1' => 'gnBasis',
        '1.2.840.10045.1.2.3.2' => 'tpBasis',
        '1.2.840.10045.1.2.3.3' => 'ppBasis',
        '1.2.840.10045.2' => 'id-publicKeyType',
        '1.2.840.10045.2.1' => 'id-ecPublicKey',
        '1.2.840.10045.3' => 'ellipticCurve',
        '1.2.840.10045.3.0' => 'c-TwoCurve',
        '1.2.840.10045.3.0.1' => 'c2pnb163v1',
        '1.2.840.10045.3.0.2' => 'c2pnb163v2',
        '1.2.840.10045.3.0.3' => 'c2pnb163v3',
        '1.2.840.10045.3.0.4' => 'c2pnb176w1',
        '1.2.840.10045.3.0.5' => 'c2pnb191v1',
        '1.2.840.10045.3.0.6' => 'c2pnb191v2',
        '1.2.840.10045.3.0.7' => 'c2pnb191v3',
        '1.2.840.10045.3.0.8' => 'c2pnb191v4',
        '1.2.840.10045.3.0.9' => 'c2pnb191v5',
        '1.2.840.10045.3.0.10' => 'c2pnb208w1',
        '1.2.840.10045.3.0.11' => 'c2pnb239v1',
        '1.2.840.10045.3.0.12' => 'c2pnb239v2',
        '1.2.840.10045.3.0.13' => 'c2pnb239v3',
        '1.2.840.10045.3.0.14' => 'c2pnb239v4',
        '1.2.840.10045.3.0.15' => 'c2pnb239v5',
        '1.2.840.10045.3.0.16' => 'c2pnb272w1',
        '1.2.840.10045.3.0.17' => 'c2pnb304w1',
        '1.2.840.10045.3.0.18' => 'c2pnb359v1',
        '1.2.840.10045.3.0.19' => 'c2pnb368w1',
        '1.2.840.10045.3.0.20' => 'c2pnb431r1',
        '1.2.840.10045.3.1' => 'primeCurve',
        '1.2.840.10045.3.1.1' => 'prime192v1',
        '1.2.840.10045.3.1.2' => 'prime192v2',
        '1.2.840.10045.3.1.3' => 'prime192v3',
        '1.2.840.10045.3.1.4' => 'prime239v1',
        '1.2.840.10045.3.1.5' => 'prime239v2',
        '1.2.840.10045.3.1.6' => 'prime239v3',
        '1.2.840.10045.3.1.7' => 'prime256v1',
        '1.2.840.113549.1.1.7' => 'id-RSAES-OAEP',
        '1.2.840.113549.1.1.9' => 'id-pSpecified',
        '1.2.840.113549.1.1.10' => 'id-RSASSA-PSS',
        '1.2.840.113549.1.1.8' => 'id-mgf1',
        '1.2.840.113549.1.1.14' => 'sha224WithRSAEncryption',
        '1.2.840.113549.1.1.11' => 'sha256WithRSAEncryption',
        '1.2.840.113549.1.1.12' => 'sha384WithRSAEncryption',
        '1.2.840.113549.1.1.13' => 'sha512WithRSAEncryption',
        '2.16.840.1.101.3.4.2.4' => 'id-sha224',
        '2.16.840.1.101.3.4.2.1' => 'id-sha256',
        '2.16.840.1.101.3.4.2.2' => 'id-sha384',
        '2.16.840.1.101.3.4.2.3' => 'id-sha512',
        '1.2.643.2.2.4' => 'id-GostR3411-94-with-GostR3410-94',
        '1.2.643.2.2.3' => 'id-GostR3411-94-with-GostR3410-2001',
        '1.2.643.2.2.20' => 'id-GostR3410-2001',
        '1.2.643.2.2.19' => 'id-GostR3410-94',
        // Netscape Object Identifiers from "Netscape Certificate Extensions"
        '2.16.840.1.113730' => 'netscape',
        '2.16.840.1.113730.1' => 'netscape-cert-extension',
        '2.16.840.1.113730.1.1' => 'netscape-cert-type',
        '2.16.840.1.113730.1.13' => 'netscape-comment',
        '2.16.840.1.113730.1.8' => 'netscape-ca-policy-url',
        // the following are X.509 extensions not supported by phpseclib
        '1.3.6.1.5.5.7.1.12' => 'id-pe-logotype',
        '1.2.840.113533.7.65.0' => 'entrustVersInfo',
        '2.16.840.1.113733.1.6.9' => 'verisignPrivate',
        // for Certificate Signing Requests
        // see http://tools.ietf.org/html/rfc2985
        '1.2.840.113549.1.9.2' => 'pkcs-9-at-unstructuredName', // PKCS #9 unstructured name
        '1.2.840.113549.1.9.7' => 'pkcs-9-at-challengePassword', // Challenge password for certificate revocations
        '1.2.840.113549.1.9.14' => 'pkcs-9-at-extensionRequest' // Certificate extension request
    ];


    public static function getTagClass($type)
    {
        return $type >> 6;
    }

    public static function isStructure($type)
    {
        return ($type & 0x20) > 0;
    }

    public static function getTag($type)
    {
        return $type & 0x1f;
    }

    public static function getTagName($type)
    {
        return self::TAG_NAMES[self::getTag($type)];
    }

}
