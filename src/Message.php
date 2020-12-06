<?php
namespace Cactus\Mammillaria;

class Message
{

    /**
     * File path
     *
     * @var string
     */
    var string $path;

    /**
     *
     * - r
     * - w
     * - rw
     *
     * @var string
     */
    var string $access;

    var $expiry;

    public function hasReadPermission()
    {
        return strpos($this->access, 'r') !== false;
    }

    public function hasWritePermission()
    {
        return strpos($this->access, 'w') !== false;
    }

    public function isExpired()
    {
        return isset($this->expiry) && gmdate("Y-m-d H:i:s") > $this->expiry;
    }
}

