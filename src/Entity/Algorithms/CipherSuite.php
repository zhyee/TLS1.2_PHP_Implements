<?php

namespace TLS\Entity\Algorithms;

class CipherSuite
{
    const TLS_NULL_WITH_NULL_NULL = 0x0000;

    const TLS_RSA_WITH_NULL_MD5 = 0x0001;
    const TLS_RSA_WITH_NULL_SHA = 0x0002;
    const TLS_RSA_WITH_NULL_SHA256 = 0x003b;
    const TLS_RSA_WITH_RC4_128_MD5 = 0x0004;
    const TLS_RSA_WITH_RC4_128_SHA = 0x0005;
    const TLS_RSA_WITH_3DES_EDE_CBC_SHA = 0x000a;
    const TLS_RSA_WITH_AES_128_CBC_SHA = 0x002f;
    const TLS_RSA_WITH_AES_256_CBC_SHA = 0x0035;
    const TLS_RSA_WITH_AES_128_CBC_SHA256 = 0x003c;
    const TLS_RSA_WITH_AES_256_CBC_SHA256 = 0x003d;

    const TLS_DH_DSS_WITH_3DES_EDE_CBC_SHA = 0x000D;
    const TLS_DH_RSA_WITH_3DES_EDE_CBC_SHA = 0x0010;
    const TLS_DHE_DSS_WITH_3DES_EDE_CBC_SHA = 0x0013;
    const TLS_DHE_RSA_WITH_3DES_EDE_CBC_SHA = 0x0016;
    const TLS_DH_DSS_WITH_AES_128_CBC_SHA = 0x0030;
    const TLS_DH_RSA_WITH_AES_128_CBC_SHA = 0x0031;
    const TLS_DHE_DSS_WITH_AES_128_CBC_SHA = 0x0032;
    const TLS_DHE_RSA_WITH_AES_128_CBC_SHA = 0x0033;
    const TLS_DH_DSS_WITH_AES_256_CBC_SHA = 0x0036;
    const TLS_DH_RSA_WITH_AES_256_CBC_SHA = 0x0037;
    const TLS_DHE_DSS_WITH_AES_256_CBC_SHA = 0x0038;
    const TLS_DHE_RSA_WITH_AES_256_CBC_SHA = 0x0039;
    const TLS_DH_DSS_WITH_AES_128_CBC_SHA256 = 0x003E;
    const TLS_DH_RSA_WITH_AES_128_CBC_SHA256 = 0x003F;
    const TLS_DHE_DSS_WITH_AES_128_CBC_SHA256 = 0x0040;
    const TLS_DHE_RSA_WITH_AES_128_CBC_SHA256 = 0x0067;
    const TLS_DH_DSS_WITH_AES_256_CBC_SHA256 = 0x0068;
    const TLS_DH_RSA_WITH_AES_256_CBC_SHA256 = 0x0069;
    const TLS_DHE_DSS_WITH_AES_256_CBC_SHA256 = 0x006A;
    const TLS_DHE_RSA_WITH_AES_256_CBC_SHA256 = 0x006B;

    const TLS_DH_anon_WITH_RC4_128_MD5 = 0x0018;
    const TLS_DH_anon_WITH_3DES_EDE_CBC_SHA = 0x001B;
    const TLS_DH_anon_WITH_AES_128_CBC_SHA = 0x0034;
    const TLS_DH_anon_WITH_AES_256_CBC_SHA = 0x003A;
    const TLS_DH_anon_WITH_AES_128_CBC_SHA256 = 0x006C;
    const TLS_DH_anon_WITH_AES_256_CBC_SHA256 = 0x006D;

    const CIPHER_SUITE_NAMES = [
        self::TLS_NULL_WITH_NULL_NULL => 'TLS_NULL_WITH_NULL_NULL',
        self::TLS_RSA_WITH_NULL_MD5 => 'TLS_RSA_WITH_NULL_MD5',
        self::TLS_RSA_WITH_NULL_SHA => 'TLS_RSA_WITH_NULL_SHA',
        self::TLS_RSA_WITH_NULL_SHA256 => 'TLS_RSA_WITH_NULL_SHA256',
        self::TLS_RSA_WITH_RC4_128_MD5 => 'TLS_RSA_WITH_RC4_128_MD5',
        self::TLS_RSA_WITH_RC4_128_SHA => 'TLS_RSA_WITH_RC4_128_SHA',
        self::TLS_RSA_WITH_3DES_EDE_CBC_SHA => 'TLS_RSA_WITH_3DES_EDE_CBC_SHA',
        self::TLS_RSA_WITH_AES_128_CBC_SHA => 'TLS_RSA_WITH_AES_128_CBC_SHA',
        self::TLS_RSA_WITH_AES_256_CBC_SHA => 'TLS_RSA_WITH_AES_256_CBC_SHA',
        self::TLS_RSA_WITH_AES_128_CBC_SHA256 => 'TLS_RSA_WITH_AES_128_CBC_SHA256',
        self::TLS_RSA_WITH_AES_256_CBC_SHA256 => 'TLS_RSA_WITH_AES_256_CBC_SHA256',

        self::TLS_DH_DSS_WITH_3DES_EDE_CBC_SHA => 'TLS_DH_DSS_WITH_3DES_EDE_CBC_SHA',
        self::TLS_DH_RSA_WITH_3DES_EDE_CBC_SHA => 'TLS_DH_RSA_WITH_3DES_EDE_CBC_SHA',
        self::TLS_DHE_DSS_WITH_3DES_EDE_CBC_SHA => 'TLS_DHE_DSS_WITH_3DES_EDE_CBC_SHA',
        self::TLS_DHE_RSA_WITH_3DES_EDE_CBC_SHA => 'TLS_DHE_RSA_WITH_3DES_EDE_CBC_SHA',
        self::TLS_DH_DSS_WITH_AES_128_CBC_SHA => 'TLS_DH_DSS_WITH_AES_128_CBC_SHA',
        self::TLS_DH_RSA_WITH_AES_128_CBC_SHA => 'TLS_DH_RSA_WITH_AES_128_CBC_SHA',
        self::TLS_DHE_DSS_WITH_AES_128_CBC_SHA => 'TLS_DHE_DSS_WITH_AES_128_CBC_SHA',
        self::TLS_DHE_RSA_WITH_AES_128_CBC_SHA => 'TLS_DHE_RSA_WITH_AES_128_CBC_SHA',
        self::TLS_DH_DSS_WITH_AES_256_CBC_SHA => 'TLS_DH_DSS_WITH_AES_256_CBC_SHA',
        self::TLS_DH_RSA_WITH_AES_256_CBC_SHA => 'TLS_DH_RSA_WITH_AES_256_CBC_SHA',
        self::TLS_DHE_DSS_WITH_AES_256_CBC_SHA => 'TLS_DHE_DSS_WITH_AES_256_CBC_SHA',
        self::TLS_DHE_RSA_WITH_AES_256_CBC_SHA => 'TLS_DHE_RSA_WITH_AES_256_CBC_SHA',
        self::TLS_DH_DSS_WITH_AES_128_CBC_SHA256 => 'TLS_DH_DSS_WITH_AES_128_CBC_SHA256',
        self::TLS_DH_RSA_WITH_AES_128_CBC_SHA256 => 'TLS_DH_RSA_WITH_AES_128_CBC_SHA256',
        self::TLS_DHE_DSS_WITH_AES_128_CBC_SHA256 => 'TLS_DHE_DSS_WITH_AES_128_CBC_SHA256',
        self::TLS_DHE_RSA_WITH_AES_128_CBC_SHA256 => 'TLS_DHE_RSA_WITH_AES_128_CBC_SHA256',
        self::TLS_DH_DSS_WITH_AES_256_CBC_SHA256 => 'TLS_DH_DSS_WITH_AES_256_CBC_SHA256',
        self::TLS_DH_RSA_WITH_AES_256_CBC_SHA256 => 'TLS_DH_RSA_WITH_AES_256_CBC_SHA256',
        self::TLS_DHE_DSS_WITH_AES_256_CBC_SHA256 => 'TLS_DHE_DSS_WITH_AES_256_CBC_SHA256',
        self::TLS_DHE_RSA_WITH_AES_256_CBC_SHA256 => 'TLS_DHE_RSA_WITH_AES_256_CBC_SHA256',

        self::TLS_DH_anon_WITH_RC4_128_MD5 => 'TLS_DH_anon_WITH_RC4_128_MD5',
        self::TLS_DH_anon_WITH_3DES_EDE_CBC_SHA => 'TLS_DH_anon_WITH_3DES_EDE_CBC_SHA',
        self::TLS_DH_anon_WITH_AES_128_CBC_SHA => 'TLS_DH_anon_WITH_AES_128_CBC_SHA',
        self::TLS_DH_anon_WITH_AES_256_CBC_SHA => 'TLS_DH_anon_WITH_AES_256_CBC_SHA',
        self::TLS_DH_anon_WITH_AES_128_CBC_SHA256 => 'TLS_DH_anon_WITH_AES_128_CBC_SHA256',
        self::TLS_DH_anon_WITH_AES_256_CBC_SHA256 => 'TLS_DH_anon_WITH_AES_256_CBC_SHA256',
    ];

    private $cipherSuiteNo;

    /**
     * CipherSuite constructor.
     * @param int $noFirstByte 加密套件高8位
     * @param int $noSecondByte 加密套件低8位
     */
    public function __construct($noFirstByte, $noSecondByte)
    {
        $noFirstByte &= 0xff;
        $noSecondByte &= 0xff;
        $this->cipherSuiteNo = ($noFirstByte << 8) | $noSecondByte;
    }

    public function getName()
    {
        return self::getNameByNo($this->cipherSuiteNo);
    }

    /**
     * @param $cipherSuiteNo
     * @return false|string
     */
    public static function packCipherSuiteNo($cipherSuiteNo)
    {
        return pack('CC', ($cipherSuiteNo >> 8) & 0xff, $cipherSuiteNo & 0xff);
    }
    /**
     * 返回可读的加密套件名
     * @param $cipherSuiteNo
     * @return string
     */
    public static function getNameByNo($cipherSuiteNo)
    {
        return self::CIPHER_SUITE_NAMES[$cipherSuiteNo] ?? '';
    }
}