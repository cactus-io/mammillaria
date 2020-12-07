<?php
namespace Cactus\Mammillaria\Tests;

use Cactus\Mammillaria\TokenMessage;
use Cactus\Mammillaria\MessageToFile;
use Cactus\Mammillaria\Exceptions\PermissionDeniedException;
use PHPUnit\Framework\TestCase;
use Cactus\Mammillaria\Exceptions\FileNotFoundException;

class MessageToFileTest extends TestCase
{

    /**
     *
     * @test
     */
    public function provideParamsFileExisted()
    {
        $message = new TokenMessage();
        $message->access = 'rw';
        $message->expiry = '3000-01-01 00:00:00:';
        $message->path = basename(__FILE__);

        $convertor = new MessageToFile(__DIR__);
        $this->assertEquals($convertor($message), __FILE__);
    }

    /**
     *
     * @test
     */
    public function fileNotFound()
    {
        $this->expectException(FileNotFoundException::class);

        $message = new TokenMessage();
        $message->access = 'rw';
        $message->expiry = '3000-01-01 00:00:00:';
        $message->path = '/xxx.txt';

        $convertor = new MessageToFile(__DIR__);
        $this->assertEquals($convertor($message), __DIR__ . $message->path);
    }

    /**
     *
     * @test
     */
    public function permissionDeniedMessage()
    {
        $this->expectException(PermissionDeniedException::class);

        $message = new TokenMessage();
        $message->access = 'xx';
        $message->expiry = '3000-01-01 00:00:00:';
        $message->path = basename(__FILE__);

        $convertor = new MessageToFile(__DIR__);
        $this->assertEquals($convertor($message), __DIR__ . $message->path);
    }
}

