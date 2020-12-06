<?php

namespace TLS\Entity\Handshakes;

use TLS\Contracts\Resolvable;
use TLS\Contracts\StringAble;
use TLS\Entity\Algorithms\CipherSuite;

class ClientHello extends BaseHello implements StringAble,Resolvable
{

    public $cipherSuiteArr;
    public $compressionMethodArr;

    public function __construct (
        $TLSMajorVersion,
        $TLSMinorVersion,
        $randomStr,
        $sessionId,
        array $cipherSuiteArr,
        array $compressionMethodArr,
        array $extensionArr
    ) {
        $this->TLSMajorVersion = $TLSMajorVersion;
        $this->TLSMinorVersion = $TLSMinorVersion;
        $this->randomStr = $randomStr;
        $this->sessionId = $sessionId;
        $this->cipherSuiteArr = $cipherSuiteArr;
        $this->compressionMethodArr = $compressionMethodArr;
        $this->extensionArr = $extensionArr;
    }

    public function toByteString()
    {
        $stream = pack('CC', $this->TLSMajorVersion, $this->TLSMinorVersion);

        $stream .= $this->randomStr;

        if (!is_null($this->sessionId)) {
            $stream .= pack('C', strlen($this->sessionId));
            $stream .= $this->sessionId;
        } else {
            $stream .= pack('C', 0);
        }

        $stream .= pack('n', count($this->cipherSuiteArr) * 2);
        foreach ($this->cipherSuiteArr as $cipherSuiteNo) {
            $stream .= CipherSuite::packCipherSuiteNo($cipherSuiteNo);
        }

        $stream .= pack('C', count($this->compressionMethodArr));
        foreach ($this->compressionMethodArr as $compressionMethod) {
            $stream .= pack('C', (int)$compressionMethod);
        }

        $streamLen = strlen($stream);
        $extensionLen = 0;
        $extensionStream = '';

        /** @var HelloExtension $extension */
        foreach ($this->extensionArr as $extension) {
            $extensionData = $extension->data;
            if ($extensionData instanceof StringAble) {
                $extensionData = $extensionData->toByteString();
            }
            $extensionLen += 4 + strlen($extensionData);
            $extensionStream .= pack('n', $extension->type);
            $extensionStream .= pack('n', strlen($extensionData));
            $extensionStream .= $extensionData;
        }

        // 补齐handshake数据包长度为512，handshake数据包本身有4字节的头部，所以clientHello补齐到508字节即可, 即 $streamLen + 2（存储所有扩展的长度和）+ $extensionLen = 508
        // 所以补齐字节后 $streamLen + $extensionLen 应该为 506，同时每个扩展的头部需要占用4字节（2字节存储该扩展类型+2字节存储该扩展长度）
        // 所以补齐前的 $streamLen + $extensionLen 不能超过502字节，否则补齐一个最短的padding扩展（4字节）也会超过506。
        if ($streamLen + $extensionLen <= 502) {
            $paddingLen = 502 - $streamLen - $extensionLen;
            $extensionStream .= pack('n', HelloExtension::TYPE_PADDING);
            $extensionStream .= pack('n', $paddingLen);
            $extensionStream .= str_repeat("\x0", $paddingLen);
            $extensionLen = $extensionLen + 4 + $paddingLen;
        }

        $stream .= pack('n', $extensionLen);
        $stream .= $extensionStream;

        return $stream;
    }

    public static function resolveFromSocket($socket)
    {
        // TODO: Implement resolveFromSocket() method.
    }

    /**
     * 从字节流中解析出相应实体
     * @param string $string
     * @return self
     */
    public static function resolveFromString(&$string)
    {
        // TODO: Implement resolveFromString() method.
    }
}
