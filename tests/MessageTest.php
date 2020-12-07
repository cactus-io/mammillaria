<?php
namespace Cactus\Mammillaria\Tests;

use PHPUnit\Framework\TestCase;
use Cactus\Mammillaria\TokenMessage;

class MessageTest extends TestCase
{

    /**
     *
     * @test
     */
    public function redAccessPermissionTest()
    {
        $TokenMessage = new TokenMessage();
        $TokenMessage->access = 'rw';
        $this->assertTrue($TokenMessage->hasReadPermission(), 'Red access is not valid');
        $this->assertTrue($TokenMessage->hasWritePermission(), 'Write access is not valid');

        $TokenMessage->access = 'r';
        $this->assertTrue($TokenMessage->hasReadPermission(), 'Red access is not valid');
        $this->assertFalse($TokenMessage->hasWritePermission(), 'Write access is not valid');

        $TokenMessage->access = 'w';
        $this->assertFalse($TokenMessage->hasReadPermission(), 'Red access is not valid');
        $this->assertTrue($TokenMessage->hasWritePermission(), 'Write access is not valid');
    }

    /**
     * 
     * @test
     */
    public function expiryTest()
    {
        $TokenMessage = new TokenMessage();
        $TokenMessage->expiry = '1900-01-01 00:00:00';
        $this->assertTrue($TokenMessage->isExpired(), 'expired is not valid');

        $TokenMessage = new TokenMessage();
        $TokenMessage->expiry = '3000-01-01 00:00:00';
        $this->assertFalse($TokenMessage->isExpired(), 'expired is not valid');
    }
}

