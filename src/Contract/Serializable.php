<?php

namespace TLS\Contract;

interface Serializable
{
    /**
     * @return string
     */
    public function toByteStream();
}
