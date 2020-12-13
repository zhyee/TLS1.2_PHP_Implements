<?php
namespace TLS\Library\ASN1;

class ASN1Resolver
{
    protected $plaintext;

    protected $pos = 0;

    /**
     * ASN1Resolver constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param $filepath
     * @return ASN1Resolver
     */
    public static function initFromFile($filepath)
    {
        $plaintext = file_get_contents($filepath);
        return self::initFromText($plaintext);
    }

    /**
     * @param $plaintext
     * @return ASN1Resolver
     */
    public static function initFromText($plaintext)
    {
        $instance = new self();
        $instance->plaintext = $plaintext;
        return $instance;
    }

    protected function getNextSubStr($len)
    {
        $subStr = substr($this->plaintext, $this->pos, $len);
        $this->pos += $len;
        return $subStr;
    }

    protected function getNextByte()
    {
        return ord($this->plaintext[$this->pos++]);
    }

    protected function getLength()
    {
        $length = $this->getNextByte();
        if ($length == 0x80) {
            return 0;
        } else {
            $flag = $length >> 7;
            if ($flag == 0) {
                return $length;
            } else {
                $bytes = $length & 0x7f;
                $length = 0;
                while ($bytes-- > 0) {
                    $length = ($length << 8) + $this->getNextByte();
                }
                return $length;
            }
        }
    }

    public function resolve()
    {
        $result = [];
        $totalLength = strlen($this->plaintext);
        while ($this->pos < $totalLength) {
            $type = $this->getNextByte();
            $length = $this->getLength();
            $class = ASN1Type::getTagClass($type);
            $tag = ASN1Type::getTag($type);
            $asn1 = new ASN1Entity();
            $asn1->class = $class;
            $asn1->tag = $tag;
            $asn1->tagName = ASN1Type::getTagName($type);
            $asn1->length = $length;

            $value = $this->getNextSubStr($length);

            if (ASN1Type::isStructure($type)) {

                $asn1->value = self::initFromText($value)->resolve();

            } else {
                $asn1->value = self::resolveBasic($tag, $value);
            }

            $result[] = $asn1;
        }

        return $result;
    }

    public static function parseUTCTime($utcTime)
    {
        list($year, $month, $day, $hour, $minute, $second, ) = str_split($utcTime, 2);
        if ($year < 50) {
            $year += 2000;
        } else {
            $year += 1900;
        }

        $unixTime = strtotime("$year-$month-$day $hour:$minute:$second +0:00");

        date_default_timezone_set('Asia/Shanghai');

        return date('Y-m-d H:i:s', $unixTime);
    }

    public static function parseGeneralizedTime($generalTime)
    {
        list($yearPrefix, $year, $month, $day, $hour, $minute, $second, ) = str_split($generalTime, 2);
        $unixTime = strtotime("{$yearPrefix}{$year}-$month-$day $hour:$minute:$second +0:00");

        date_default_timezone_set('Asia/Shanghai');

        return date('Y-m-d H:i:s', $unixTime);
    }

    /**
     * 解析OID编码，转为点分10进制格式
     * @param $oid
     * @return string
     */
    public static function parseOID($oid)
    {
        $len = strlen($oid);
        $pieces = [];
        $num = 0;
        for($i = 0; $i < $len; $i++) {
            $char = ord($oid[$i]);
            $num = ($num << 7) | ($char & 0x7f);
            if (($char >> 7) == 0) {
                $pieces[] = $num;
                $num = 0;
            }
        }

        $oidString = floor($pieces[0] / 40) . '.' . ($pieces[0] % 40);
        $pieces[0] = $oidString;

        $oid = implode('.', $pieces);
        return isset(ASN1Type::OBJECT_IDENTIFIERS[$oid]) ? ASN1Type::OBJECT_IDENTIFIERS[$oid] : $oid;
    }

    public static function resolveBasic($tag, $content)
    {
        switch ($tag) {

            case ASN1Type::TAG_UTF8_STRING:
            case ASN1Type::TAG_PRINTABLE_STRING:
            case ASN1Type::TAG_IA5_STRING:
                return $content;
                break;
            case ASN1Type::TAG_OBJECT_IDENTIFIER:
                return self::parseOID($content);
                break;
            case ASN1Type::TAG_UTC_TIME:
                return self::parseUTCTime($content);
                break;
            case ASN1Type::TAG_GENERALIZED_TIME:
                return self::parseGeneralizedTime($content);
                break;
            default:
                $value = '';
                for ($i = 0; $i < strlen($content); $i++) {
                    $value .= '0x' . dechex(ord($content[$i])) . ' ';
                }
                return $value;
        }
    }

    public static function loadFromText($text)
    {
        return self::initFromText($text)->resolve();
    }

}