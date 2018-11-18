<?php declare(strict_types=1);

namespace TestApi\Entity\Validator;

interface Validator
{
    /**
     * @param array $attributes
     *
     * @return mixed
     * @throws \\Validation\ValidationException;
     */
    public function validate(array $attributes);
}
