<?php declare(strict_types=1);

namespace TestApi\Validators;

use TestApi\Domain\Language\Validator\LanguageValidator as LanguageValidatorInterface;

class LanguageValidator extends AbstractValidator implements LanguageValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'id'   => 'sometimes|required|exists:name,language_id',
            'name' => ['required', 'max:20'],
        ];
    }
}
