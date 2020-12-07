<?php
use Pluf\Scion\Process\HttpProcess;

return [
    FileToHttpResponse::class,
    [
        new HttpProcess('#^/api/v2/cactus/files/(?P<token>.+)/content$#', [
            'GET'
        ]),
        'FileToHttpResponseUnit',
        'JwtToMessageUnit',
        'MessageToFileUnit'
    ],
    function () {
        throw new \Exception('Not implemented yet!');
    }
];