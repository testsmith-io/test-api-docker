<?php declare(strict_types=1);

namespace TestApi\Exceptions;

use Exception;

class TestApiException extends Exception
{
    /**
     * @param string $message
     * @param mixed  $arguments
     */
    public function __construct($message = '', $arguments = null)
    {
        $message = vsprintf($message, (array)$arguments);

        parent::__construct($message);
    }
}
