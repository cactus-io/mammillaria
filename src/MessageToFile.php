<?php
namespace Cactus\Mammillaria;

use Cactus\Mammillaria\Exceptions\FileNotFoundException;
use Cactus\Mammillaria\Exceptions\PermissionDeniedException;

/**
 * Converts request message into a file
 *
 *
 * @author maso
 * @since 7.0.0
 */
class MessageToFile
{

    /**
     * Base of the storage path
     *
     * @var string
     */
    private string $storage;

    public function __construct(string $storage = '/mnt/storage')
    {
        $this->storage = $storage;
    }

    public function __invoke(Message $message)
    {

        // check access of read
        if (! $message->hasReadPermission()) {
            throw new PermissionDeniedException('No red permission');
        }

        /*
         * Response file
         */
        if (strpos($message->path, DIRECTORY_SEPARATOR) === 0) {
            $path = $this->storage . $message->path;
        } else {
            $path = $this->storage . DIRECTORY_SEPARATOR . $message->path;
        }

        if (! file_exists($path) || ! is_readable($path)) {
            throw new FileNotFoundException('File not found: ' . $message->path);
        }

        return $path;
    }
}

