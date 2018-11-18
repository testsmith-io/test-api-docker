<?php declare(strict_types=1);

namespace TestApi\Validators;

use TestApi\Domain\Store\Validator\StoreValidator as StoreValidatorInterface;

class StoreValidator extends AbstractValidator implements StoreValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'storeId'        => 'sometimes|required|exists:store,store_id',
            'managerStaffId' => 'required|exists:staff,staff_id',
            'addressId'      => 'required|exists:address,address_id',
        ];
    }
}
