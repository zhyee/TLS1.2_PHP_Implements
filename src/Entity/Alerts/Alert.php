<?php
namespace TLS\Entity\Records;

use TLS\Exceptions\AlertException;
use TLS\Exceptions\FragmentException;

class Alert
{
    const LEVEL_WARNING = 1; // 警告级别
    const LEVEL_FATAL = 2;  // 致命错误

    /**
     * 错误码
     */
    const DESC_CODE_CLOSE_NOTIFY = 0;
    const DESC_CODE_UNEXPECTED_MESSAGE = 10;
    const DESC_CODE_BAD_RECORD_MAC = 20;
    const DESC_CODE_DECRYPTION_FAILED_RESERVED = 21;
    const DESC_CODE_RECORD_OVERFLOW = 22;
    const DESC_CODE_DECOMPRESSION_FAILURE = 30;
    const DESC_CODE_HANDSHAKE_FAILURE = 40;
    const DESC_CODE_NO_CERTIFICATE_RESERVED = 41;
    const DESC_CODE_BAD_CERTIFICATE = 42;
    const DESC_CODE_UNSUPPORTED_CERTIFICATE = 43;
    const DESC_CODE_CERTIFICATE_REVOKED = 44;
    const DESC_CODE_CERTIFICATE_EXPIRED = 45;
    const DESC_CODE_CERTIFICATE_UNKNOWN = 46;
    const DESC_CODE_ILLEGAL_PARAMETER = 47;
    const DESC_CODE_UNKNOWN_CA = 48;
    const DESC_CODE_ACCESS_DENIED = 49;
    const DESC_CODE_DECODE_ERROR = 50;
    const DESC_CODE_DECRYPT_ERROR = 51;
    const DESC_CODE_EXPORT_RESTRICTION_RESERVED = 52;
    const DESC_CODE_PROTOCOL_VERSION = 53;
    const DESC_CODE_INSUFFICIENT_SECURITY = 71;
    const DESC_CODE_INTERNAL_ERROR = 80;
    const DESC_CODE_USER_CANCELED = 90;
    const DESC_CODE_NO_RENEGOTIATION = 100;
    const DESC_CODE_UNSUPPORTED_EXTENSION = 110;

    /**
     * 错误描述
     */
    const ALERT_DESCRIPTIONS = [
        self::DESC_CODE_CLOSE_NOTIFY => 'close notify',
        self::DESC_CODE_UNEXPECTED_MESSAGE => 'unexpected message',
        self::DESC_CODE_BAD_RECORD_MAC => 'bad record mac',
        self::DESC_CODE_DECRYPTION_FAILED_RESERVED => 'decryption failed reserved',
        self::DESC_CODE_RECORD_OVERFLOW => 'record overflow',
        self::DESC_CODE_DECOMPRESSION_FAILURE => 'decompression failure',
        self::DESC_CODE_HANDSHAKE_FAILURE => 'handshake failure',
        self::DESC_CODE_NO_CERTIFICATE_RESERVED => 'no certificate reserved',
        self::DESC_CODE_BAD_CERTIFICATE => 'bad certificate',
        self::DESC_CODE_UNSUPPORTED_CERTIFICATE => 'unsupported certificate',
        self::DESC_CODE_CERTIFICATE_REVOKED => 'certificate revoked',
        self::DESC_CODE_CERTIFICATE_EXPIRED => 'certificate expired',
        self::DESC_CODE_CERTIFICATE_UNKNOWN => 'certificate unknown',
        self::DESC_CODE_ILLEGAL_PARAMETER => 'illegal parameter',
        self::DESC_CODE_UNKNOWN_CA => 'unknown ca',
        self::DESC_CODE_ACCESS_DENIED => 'access denied',
        self::DESC_CODE_DECODE_ERROR => 'decode error',
        self::DESC_CODE_DECRYPT_ERROR => 'decrypt error',
        self::DESC_CODE_EXPORT_RESTRICTION_RESERVED => 'export restriction reserved',
        self::DESC_CODE_PROTOCOL_VERSION => 'protocol version',
        self::DESC_CODE_INSUFFICIENT_SECURITY => 'insufficient security',
        self::DESC_CODE_INTERNAL_ERROR => 'internal error',
        self::DESC_CODE_USER_CANCELED => 'user canceled',
        self::DESC_CODE_NO_RENEGOTIATION => 'no renegotiation',
        self::DESC_CODE_UNSUPPORTED_EXTENSION => 'unsupported extension',
    ];

    public $level;
    public $description;

    public function __construct($level, $description)
    {
        $this->level = $level;
        $this->description = $description;
    }

    /**
     * @return AlertException
     * @throws FragmentException
     */
    public function toException()
    {
        if (!isset(self::ALERT_DESCRIPTIONS[$this->description])) {
            throw new FragmentException('错误的Alert description code');
        }
        return new AlertException(self::ALERT_DESCRIPTIONS[$this->description], $this->description);
    }

    /**
     * @throws AlertException
     * @throws FragmentException
     */
    public function throwsException()
    {
        throw $this->toException();
    }

}