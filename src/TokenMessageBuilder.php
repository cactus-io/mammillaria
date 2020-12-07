<?php
namespace Cactus\Mammillaria;

use Firebase\JWT\JWT;
use Cactus\Mammillaria\Exceptions\InvalidTokenException;

class TokenMessageBuilder
{

    private $expirey;

    private $access = 'rw';

    private string $path;

    private $host;

    private $account;

    public static function newInstance(): TokenMessageBuilder
    {
        return new TokenMessageBuilder();
    }

    public function setExpiry($expiry): TokenMessageBuilder
    {
        $this->expirey = $expiry;
        return $this;
    }

    public function setAccess($access): TokenMessageBuilder
    {
        $this->access = $access;
        return $this;
    }

    public function setPath($path): TokenMessageBuilder
    {
        $this->path = $path;
        return $this;
    }

    public function setHost($host): TokenMessageBuilder
    {
        $this->host = $host;
        return $this;
    }

    public function setAccount($account): TokenMessageBuilder
    {
        $this->account = $account;
        return $this;
    }

    public function sign(string $key, string $algorithem = 'HS256'): string
    {
        $tokenMessage = new TokenMessage();

        // 1. access
        if (strcmp($this->access, 'r') !== 0 && strcmp($this->access, 'rw') !== 0 && strcmp($this->access, 'w') !== 0) {
            throw new InvalidTokenException('Access must be r, w, or rw.');
        }
        $tokenMessage->access = $this->access;

        // 2. expiry
        $tokenMessage->expiry = $this->expirey;

        // 2. path
        $tokenMessage->path = $this->path;

        // 3. host
        $tokenMessage->host = $this->host;

        // 4. account
        $tokenMessage->account = $this->account;

        return JWT::encode($tokenMessage, $key, $algorithem);
    }
}

