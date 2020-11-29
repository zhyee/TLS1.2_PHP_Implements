<?php
namespace TLS\Library;

use TLS\Exceptions\SocketException;
use TLS\Exceptions\SocketIOException;

class SocketIO
{
    const BUFFERED_READ_LEN = 8192;

    /**
     * 连接服务器的socket
     * @var resource
     */
    protected $socket;

    private $buffer = '';

    private $bufferLen = 0;

    /**
     * @param $str
     * @param $len
     * @throws SocketException
     */
    protected function writeN(&$str, $len)
    {
        $writeLen = 0;
        do {
            $n = socket_write($this->socket, $str, $len - $writeLen);
            if ($n === false) {
                $errCode = socket_last_error();
                throw new SocketException('发送数据失败：' . socket_strerror($errCode), $errCode);
            }
            $writeLen += $n;
            if ($writeLen >= $len) {
                break;
            }
            if ($n > 0) {
                $str = substr($str, $n);
            }
        } while (true);
    }

    /**
     * 缓冲读指定长度的数据
     * @param $len
     * @return string
     * @throws SocketIOException
     */
    protected function bufferedRead($len)
    {
        $return = '';
        while ($len > 0) {
            if ($this->bufferLen == 0) {
                $this->buffer = socket_read($this->socket, self::BUFFERED_READ_LEN);
                if ($this->buffer === false) {
                    throw new SocketIOException('读取数据错误：' . socket_strerror(socket_last_error()), socket_last_error());
                }
                $this->bufferLen = strlen($this->buffer);
                if ($this->bufferLen < $len) {
                    $return .= $this->buffer;
                    $this->buffer = '';
                    $len -= $this->bufferLen;
                    $this->bufferLen = 0;
                } else {
                    $return .= substr($this->buffer, 0, $len);
                    $this->buffer = substr($this->buffer, $len);
                    $this->bufferLen -= $len;
                    return $return;
                }
            }
        }
        return $return;
    }

    /**
     * 缓冲读一个字节
     * @return int
     * @throws SocketIOException
     */
    protected function bufferedReadByte()
    {
        return ord($this->bufferedRead(1));
    }
}