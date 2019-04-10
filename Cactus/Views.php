<?php
/*
 * MIT License
 *
 * Copyright (c) 2019 cactus-io
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
use Firebase\JWT\JWT;

/**
 * Cactus default view
 *
 * @author maso(mostafa.barmshory@dpq.co.ir)
 */
class Cactus_Views extends Pluf_Views
{

    /**
     * Download file by a token
     *
     * @param Pluf_HTTP_Request $request
     * @param array $match
     * @return Pluf_HTTP_Response
     */
    public function downloadContent($request, $match)
    {
        $alg = Pluf::f('cactus_jwt_alg', 'HS256');
        $key = Pluf::f('cactus_jwt_key_decode');
        $token = JWT::decode($match['token'], $key, array(
            $alg
        ));

        // check access of read
        $access = $this->getAttribute($token, 'access', 'r');
        if (strpos($access, 'r') === false) {
            throw new Cactus_Exceptions_BadToken('No no permission to read', 10402, 404, 'there is no r access');
        }
        $expiry = $this->getAttribute($token, 'expiry', null);
        if (isset($expiry) && gmdate("Y-m-d H:i:s") > $expiry) {
            throw new Cactus_Exceptions_BadToken('Token is expred', 10403, 404, 'date-time field \'expiry\' if old');
        }

        // GET data
        $filePath = $token->path;

        /*
         * Response file
         */
        $path = Pluf::f('cactus_storage', __DIR__ . '/../storage/cactus') . $filePath;
        $response = new Pluf_HTTP_Response_File($path);
        $response->headers['Content-Disposition'] = sprintf('attachment; filename="%s"', basename($filePath));
        return $response;
    }
    
    /*
     * Gets property value by name
     */
    private function getAttribute ($object, $key, $default){
        if(!property_exists($object, $key)){
            return $default;
        }
        return $object->$key;
    }
}

