<?php declare(strict_types=1);

namespace TestApi\Validators;

use TestApi\Domain\Category\Validator\CategoryValidator as CategoryValidatorInterface;

class CategoryValidator extends AbstractValidator implements CategoryValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'id'   => 'sometimes|required|exists:category,category_id',
            'name' => ['required', 'max:25'],
        ];
    }
}
