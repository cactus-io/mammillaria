<?php
namespace Cactus\Mammillaria\Tests;

use Cactus\Mammillaria\JwtToMessage;
use Cactus\Mammillaria\TokenMessage;
use Cactus\Mammillaria\Exceptions\TokenExpiredException;
use Firebase\JWT\JWT;
use PHPUnit\Framework\TestCase;
use Pluf\Scion\UnitTrackerInterface;

class JwtTokenToMessageTest extends TestCase
{

    /**
     *
     * @test
     */
    public function convertToMessageValid()
    {
        $token = array(
            'path' => '/test.txt',
            'expiry' => '3000-01-01 00:00:00',
            'access' => 'r',
            'account' => [
                'id' => 1
            ],
            'host' => [
                'domain' => 'localhost'
            ]
        );
        $key = '123';
        $alg = 'HS256';

        $jwt = JWT::encode($token, $key, $alg);

        // Create a stub for the SomeClass class.
        $stub = $this->createMock(UnitTrackerInterface::class);

        $message = new TokenMessage();
        $message->path = $token['path'];
        $message->expiry = $token['expiry'];
        $message->access = $token['access'];

        $arguments = [
            'message' => $message
        ];

        // Configure the stub.
        $stub->method('next')
            ->willReturn('/foo/')
            ->with($arguments);

        $processor = new JwtToMessage($key, [
            $alg
        ]);
        $path = $processor($jwt, $stub);
        $this->assertNotNull($path);
        $this->assertEquals($path, '/foo/');
    }

    /**
     *
     * @test
     */
    public function convertToMessageValidExpired()
    {
        $this->expectException(TokenExpiredException::class);
        $token = array(
            'path' => '/test.txt',
            'expiry' => '1999-01-01 00:00:00',
            'access' => 'r',
            'account' => [
                'id' => 1
            ],
            'host' => [
                'domain' => 'localhost'
            ]
        );
        $key = '123';
        $alg = 'HS256';

        $jwt = JWT::encode($token, $key, $alg);

        // Create a stub for the SomeClass class.
        $stub = $this->createMock(UnitTrackerInterface::class);

        $message = new TokenMessage();
        $message->path = $token['path'];
        $message->expiry = $token['expiry'];
        $message->access = $token['access'];

        $arguments = [
            'message' => $message
        ];

        // Configure the stub.
        $stub->method('next')
            ->willReturn('/foo/')
            ->with($arguments);

        $processor = new JwtToMessage($key, [
            $alg
        ]);
        $path = $processor($jwt, $stub);
        $this->assertNotNull($path);
        $this->assertEquals($path, '/foo/');
    }
}

