<?php
namespace Cactus\Mammillaria;

use Cactus\Mammillaria\Exceptions\TokenExpiredException;
use Firebase\JWT\JWT;
use Pluf\Scion\UnitTrackerInterface;

/**
 * Converts a HTTP Request into a cactuse file request message
 *
 * @author maso
 */
class JwtToMessage
{

    private array $algorithems;

    private string $key;

    /**
     * Creates new instance of the convertor
     *
     * @param string $key
     * @param array $algorithems
     */
    public function __construct(string $key, array $algorithems = [
        'HS256'
    ])
    {
        $this->key = $key;
        $this->algorithems = $algorithems;
    }

    /*
     * Implementations.
     */
    public function __invoke(string $token, UnitTrackerInterface $unitTracker)
    {
        $token = JWT::decode($token, $this->key, $this->algorithems);
        $message = self::jwtToMessage($token);

        if ($message->isExpired()) {
            throw new TokenExpiredException('Token is expred');
        }

        return $unitTracker->next([
            'message' => $message
        ]);
    }

    /**
     * Converts JWT token to a message
     *
     * @param mixed $token
     * @return TokenMessage
     */
    public static function jwtToMessage($token): TokenMessage
    {
        $message = new TokenMessage();
        $message->path = $token->path;
        $message->access = $token->access;
        $message->expiry = $token->expiry;
        return $message;
    }
}