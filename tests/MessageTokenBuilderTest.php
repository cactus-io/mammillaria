<?php
namespace Cactus\Mammillaria\Tests;

use Cactus\Mammillaria\TokenMessageBuilder;
use PHPUnit\Framework\TestCase;
use Cactus\Mammillaria\Exceptions\InvalidTokenException;

class MessageTokenBuilderTest extends TestCase
{

    /**
     *
     * @test
     */
    public function buildATokenTest()
    {
        $token = TokenMessageBuilder::newInstance()->setAccess('rw')
            ->setExpiry('2020-01-01 00:00:00')
            ->setPath('/path/text.txt')
            ->sign('123');
        $this->assertNotNull($token);
    }

    /**
     *
     * @test
     */
    public function buildATokenWithInvalidAccessTest()
    {
        $this->expectException(InvalidTokenException::class);
        $token = TokenMessageBuilder::newInstance()->setAccess('rwx')
            ->setExpiry('2020-01-01 00:00:00')
            ->setPath('/path/text.txt')
            ->sign('123');
        $this->assertNotNull($token);
    }
}

