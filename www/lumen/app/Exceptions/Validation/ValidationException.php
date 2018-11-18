<?php declare(strict_types=1);

namespace TestApi\Exceptions\Validation;

use TestApi\Exceptions\TestApiException;

class ValidationException extends TestApiException
{
    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
