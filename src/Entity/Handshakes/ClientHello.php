<?php

namespace TLS\Entity\Handshakes;

use TLS\Contract\Serializable;

class ClientHello implements Serializable
{
    public $TLSMajorVersion;
    public $TLSMinorVersion;
    public $timestamp;
    public $randomStr;
    public $sessionId;
    public $cipherSuiteArr;
    public $compressionMethodArr;
    public $extensionArr;


    public function __construct (
        $TLSMajorVersion,
        $TLSMinorVersion,
        $timestamp,
        $randomStr,
        $sessionId,
        array $cipherSuiteArr,
        array $compressionMethodArr,
        array $extensionArr
    ) {
        $this->TLSMajorVersion = $TLSMajorVersion;
        $this->TLSMinorVersion = $TLSMinorVersion;
        $this->timestamp = $timestamp;
        $this->randomStr = $randomStr;
        $this->sessionId = $sessionId;
        $this->cipherSuiteArr = $cipherSuiteArr;
        $this->compressionMethodArr = $compressionMethodArr;
        $this->extensionArr = $extensionArr;
    }

    public function toByteStream()
    {
        $stream = pack('CCN', $this->TLSMajorVersion, $this->TLSMinorVersion, $this->timestamp);

        $stream .= $this->randomStr;

        if (!is_null($this->sessionId)) {
            $stream .= pack('C', strlen($this->sessionId));
            $stream .= $this->sessionId;
        } else {
            $stream .= pack('C', 0);
        }

        $stream .= pack('n', count($this->cipherSuiteArr) * 2);
        foreach ($this->cipherSuiteArr as $cipherSuite) {
            $stream .= pack('CC', (int)$cipherSuite[0], (int)$cipherSuite[1]);
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
            if ($extensionData instanceof Serializable) {
                $extensionData = $extensionData->toByteStream();
            }
            $extensionLen += 4 + strlen($extensionData);
            $extensionStream .= pack('n', $extension->type);
            $extensionStream .= pack('n', strlen($extensionData));
            $extensionStream .= $extensionData;
        }

        // 补齐handshake数据包长度为512，handshake数据包本身有4字节的头部，所以clientHello补齐到508字节即可
        if ($streamLen + $extensionLen <= 502) {
            $paddingLen = 502 - $streamLen - $extensionLen;
            $extensionStream .= pack('n', HelloExtension::TYPE_PADDING);
            $extensionStream .= pack('n', $paddingLen);
            $extensionStream .= str_repeat("\x0", $paddingLen);
            $extensionLen = $extensionLen + 4 + $paddingLen;
        }

        $stream .= pack('n', $extensionLen);
        $stream .= $extensionStream;

        echo 'clientHello: ' . PHP_EOL;
        for ($i = 0; $i < strlen($stream); $i++) {
            echo '\x' . dechex(ord($stream[$i]));
        }
        echo PHP_EOL;

        return $stream;
    }
}