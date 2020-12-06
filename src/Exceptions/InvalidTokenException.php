<?php
namespace Cactus\Mammillaria\Exceptions;

use Exception;

/**
 * Token exception
 *
 * @author maso (mostafa.barmshory@gmail.com)
 *        
 */
class InvalidTokenException extends Exception
{

    /**
     * Creates new instance of the class
     *
     * @param string $message
     * @param Exception $previous
     * @param string $link
     * @param string $developerMessage
     */
    public function __construct($message = null, $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
