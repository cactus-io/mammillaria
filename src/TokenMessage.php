<?php
namespace Cactus\Mammillaria;

class TokenMessage
{

    /**
     *
     * Some fields are used to address a file on the download server.
     *
     * The field 'path' is used to define full path of the file. This is an abslout file
     * path from server storage.
     *
     * As an example:
     *
     * {
     * 'path': '/a/b.txt'
     * ...
     * }
     *
     * Refers to the file 'b.txt' in the folder 'a'. If the storage path is '/path/to/storage'
     * then the full path will be:
     *
     * /path/to/storage/a/b.txt
     *
     * @var string
     */
    var string $path;

    /**
     *
     * Token is used ot control the access to a file. Here is options to control the
     * download:
     *
     * - access: the access of the user to the file
     * - expire: valid duration to access to the file.
     *
     * To control access to a file, add the following attribute:
     *
     * {
     * 'access': 'r'
     * ...
     * }
     *
     * Which means the file can be read. Here is possible option:
     *
     * - r: read
     * - w: write
     * - rw: read and write
     *
     * To limit the duration of access, add the following option:
     *
     *
     * {
     * 'expiry': {date-time}
     * ...
     * }
     *
     * For example:
     *
     *
     * {
     * 'access': 'r',
     * 'expiry': '2019-01-01 00:00:00'
     * ...
     * }
     *
     *
     * @var string
     */
    var string $access;

    /**
     * Defines how long the token is valid.
     *
     * @var string
     */
    var $expiry;

    /**
     * The server may be used in the conjuction of servral other micro-services.
     * By adding some
     * extra information about the source host, the log information is more readable.
     *
     * {
     * 'host': {...}
     * }
     *
     * For example:
     *
     * {
     * 'host': {
     * 'domain': 'www.cactus-ico.com'
     * }
     * }
     *
     * @var mixed
     */
    var $host;

    /**
     * Account information is used in logs.
     *
     *
     * {
     * 'account': {...}
     * }
     *
     *
     * @var mixed
     */
    var $account;

    /**
     * Checks if the token has read permission
     *
     * @return boolean
     */
    public function hasReadPermission()
    {
        return strpos($this->access, 'r') !== false;
    }

    /**
     * Checks if the token has write permmision
     *
     * @return boolean
     */
    public function hasWritePermission()
    {
        return strpos($this->access, 'w') !== false;
    }

    /**
     * Checks if the token is expired
     *
     * @return boolean
     */
    public function isExpired()
    {
        return isset($this->expiry) && gmdate("Y-m-d H:i:s") > $this->expiry;
    }
}

