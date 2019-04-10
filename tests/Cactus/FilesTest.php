<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\IncompleteTestError;
use Firebase\JWT\JWT;
require_once 'Pluf.php';

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class Cactus_FilesTest extends TestCase
{

    private static $client = null;

    /**
     *
     * @beforeClass
     */
    public static function createDataBase()
    {
        Pluf::start(__DIR__ . '/../../config.php');
        self::$client = new Test_Client(__DIR__ . '/../../urls.php');
    }

    /**
     * Try to download a file with bad token
     *
     * @test
     * @expectedException Exception
     */
    public function downloadFileWithBadToken()
    {
        $response = self::$client->get('/api/v2/cactus/files/THIS-IS-BAD-TOKEN/content');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Try to download a file with invalid token
     *
     * @test
     * @expectedException Exception
     */
    public function downloadFileWithInvalidToken()
    {
        $tokenValue = array(
            'path' => '/README',
            'access' => 'rw',
            'account' => array(),
            'host' => array()
        );

        $token = JWT::encode($tokenValue, 'this is a key', 'HS256');

        $response = self::$client->get('/api/v2/cactus/files/THIS-IS-BAD-TOKEN/content');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Try to download a file with bad token
     *
     * @test
     */
    public function downloadFileWithToken()
    {
        $tokenValue = array(
            'path' => '/README',
            'access' => 'rw',
            'account' => array(),
            'host' => array()
        );

        $token = JWT::encode($tokenValue, Pluf::f('cactus_jwt_key_encode'), Pluf::f('cactus_jwt_alg'));

        // Get file
        $response = self::$client->get('/api/v2/cactus/files/' . $token . '/content');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Try to download a file with bad token
     *
     * @test
     * @expectedException Pluf_Exception_DoesNotExist
     */
    public function downloadNotFoundFileWithToken()
    {
        $tokenValue = array(
            'path' => '/README' . rand(),
            'access' => 'rw',
            'account' => array(),
            'host' => array()
        );

        $token = JWT::encode($tokenValue, Pluf::f('cactus_jwt_key_encode'), Pluf::f('cactus_jwt_alg'));

        // Get file
        $response = self::$client->get('/api/v2/cactus/files/' . $token . '/content');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Checking default accss
     *
     * @test
     */
    public function downloadDefaultReadAccessToken()
    {
        $tokenValue = array(
            'path' => '/README',
//             'access' => 'r',
        );

        $token = JWT::encode($tokenValue, Pluf::f('cactus_jwt_key_encode'), Pluf::f('cactus_jwt_alg'));

        // Get file
        $response = self::$client->get('/api/v2/cactus/files/' . $token . '/content');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Try to read with write access
     *
     * @test
     * @expectedException Cactus_Exceptions_BadToken
     */
    public function downloadWithWriteToken()
    {
        $tokenValue = array(
            'path' => '/README',
            'access' => 'w',
            'account' => array(),
            'host' => array()
        );

        $token = JWT::encode($tokenValue, Pluf::f('cactus_jwt_key_encode'), Pluf::f('cactus_jwt_alg'));

        // Get file
        $response = self::$client->get('/api/v2/cactus/files/' . $token . '/content');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }
    
    
    /**
     * @test
     * @expectedException Cactus_Exceptions_BadToken
     */
    public function downloadWithExpiredDateToken()
    {
        $tokenValue = array(
            'path' => '/README',
            'access' => 'rw',
            'expiry' => '2018-00-00 00:00:00',
            'account' => array(),
            'host' => array()
        );
        
        $token = JWT::encode($tokenValue, Pluf::f('cactus_jwt_key_encode'), Pluf::f('cactus_jwt_alg'));
        
        // Get file
        $response = self::$client->get('/api/v2/cactus/files/' . $token . '/content');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }
    
    
    /**
     * @test
     */
    public function downloadExpiryDateToken()
    {
        $tokenValue = array(
            'path' => '/README',
            'access' => 'rw',
            'expiry' => gmdate('Y-m-d H:i:s', strtotime('+1 day')),
            'account' => array(),
            'host' => array()
        );
        
        $token = JWT::encode($tokenValue, Pluf::f('cactus_jwt_key_encode'), Pluf::f('cactus_jwt_alg'));
        
        // Get file
        $response = self::$client->get('/api/v2/cactus/files/' . $token . '/content');
        $this->assertNotNull($response);
        $this->assertEquals($response->status_code, 200);
    }
}



