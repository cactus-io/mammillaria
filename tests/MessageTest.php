<?php
namespace Cactus\Mammillaria\Tests;

use PHPUnit\Framework\TestCase;
use Cactus\Mammillaria\Message;

class MessageTest extends TestCase
{

    /**
     *
     * @test
     */
    public function redAccessPermissionTest()
    {
        $message = new Message();
        $message->access = 'rw';
        $this->assertTrue($message->hasReadPermission(), 'Red access is not valid');
        $this->assertTrue($message->hasWritePermission(), 'Write access is not valid');

        $message->access = 'r';
        $this->assertTrue($message->hasReadPermission(), 'Red access is not valid');
        $this->assertFalse($message->hasWritePermission(), 'Write access is not valid');

        $message->access = 'w';
        $this->assertFalse($message->hasReadPermission(), 'Red access is not valid');
        $this->assertTrue($message->hasWritePermission(), 'Write access is not valid');
    }

    /**
     * 
     * @test
     */
    public function expiryTest()
    {
        $message = new Message();
        $message->expiry = '1900-01-01 00:00:00';
        $this->assertTrue($message->isExpired(), 'expired is not valid');

        $message = new Message();
        $message->expiry = '3000-01-01 00:00:00';
        $this->assertFalse($message->isExpired(), 'expired is not valid');
    }
}

