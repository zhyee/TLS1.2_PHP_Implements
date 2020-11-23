<?php
namespace TLS\Entity\Records;

use TLS\Contract\Serializable;

class TLSPlaintextRecord extends Record implements Serializable
{

    public $contentType;
    public $TLSMajorVersion;
    public $TLSMinorVersion;
    public $fragment;

    public function __construct($contentType, $TLSMajorVersion, $TLSMinorVersion, Serializable $fragment)
    {
        $this->contentType = $contentType;
        $this->TLSMajorVersion = $TLSMajorVersion;
        $this->TLSMinorVersion = $TLSMinorVersion;
        $this->fragment = $fragment;
    }

    public function toByteStream()
    {
        $fragment = $this->fragment;
        if ($fragment instanceof Serializable) {
            $fragment = $fragment->toByteStream();
        }

        // 每个TLSPlainRecord的最大长度为 2 ^ 14, 切割成多个record来发送;
        $fragmentPieces = str_split($fragment, 1 << 14);
        $record = '';
        foreach ($fragmentPieces as $piece) {
            $record .= pack('C', $this->contentType);
            $record .= pack('CC', $this->TLSMajorVersion, $this->TLSMinorVersion);
            $record .= pack('n', strlen($piece));
            $record .= $piece;
        }
        return $record;
    }

}
