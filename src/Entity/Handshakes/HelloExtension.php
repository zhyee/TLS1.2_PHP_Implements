<?php
namespace TLS\Entity\Handshakes;

use TLS\Contract\Serializable;

class HelloExtension
{
    /**
     * 推荐使用的扩展类型
     * @see https://www.iana.org/assignments/tls-extensiontype-values/tls-extensiontype-values.xhtml
     */
    const TYPE_SERVER_NAME = 0;
    const TYPE_CLIENT_CERTIFICATE_URL = 2;
    const TYPE_TRUSTED_CA_KEYS = 3;
    const TYPE_STATUS_REQUEST = 5;
    const TYPE_USER_MAPPING = 6;
    const TYPE_SUPPORTED_GROUPS = 10;
    const TYPE_EC_POINT_FORMATS = 11;
    const TYPE_SIGNATURE_ALGORITHMS = 13;
    const TYPE_USE_SRTP = 14;
    const TYPE_HEARTBEAT = 15;
    const TYPE_APPLICATION_LAYER_PROTOCOL_NEGOTIATION = 16;
    const TYPE_STATUS_REQUEST_V2 = 17;
    const TYPE_CLIENT_CERTIFICATE_TYPE = 19;
    const TYPE_SERVER_CERTIFICATE_TYPE = 20;
    const TYPE_PADDING = 21;
    const TYPE_ENCRYPT_THEN_MAC = 22;
    const TYPE_EXTENDED_MASTER_SECRET = 23;
    const TYPE_TOKEN_BINDING = 24;
    const TYPE_CACHED_INFO = 25;
    const TYPE_COMPRESS_CERTIFICATE = 27;
    const TYPE_RECORD_SIZE_LIMIT = 28;
    const TYPE_SESSION_TICKET = 35;
    const TYPE_SUPPORTED_EKT_CIPHERS = 39;
    const TYPE_PRE_SHARED_KEY = 41;
    const TYPE_EARLY_DATA = 42;
    const TYPE_SUPPORTED_VERSIONS = 43;
    const TYPE_COOKIE = 44;
    const TYPE_PSK_KEY_EXCHANGE_MODES = 45;
    const TYPE_CERTIFICATE_AUTHORITIES = 47;
    const TYPE_OID_FILTERS = 48;
    const TYPE_POST_HANDSHAKE_AUTH = 49;
    const TYPE_SIGNATURE_ALGORITHMS_CERT = 50;
    const TYPE_KEY_SHARE = 51;
    const TYPE_EXTERNAL_ID_HASH = 55;
    const TYPE_EXTERNAL_SESSION_ID = 56;

    public $type;
    public $data;

    public function __construct($type, Serializable $data)
    {
        $this->type = $type;
        $this->data = $data;
    }
}
