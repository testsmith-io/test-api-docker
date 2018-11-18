<?php declare(strict_types=1);

namespace TestApi\Validators;

use TestApi\Domain\Inventory\Validator\InventoryValidator as InventoryValidatorInterface;

class InventoryValidator extends AbstractValidator implements InventoryValidatorInterface
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'inventoryId' => 'sometimes|required|exists:inventory,inventory_id',
            'filmId'      => 'required|exists:film,film_id',
            'storeId'     => 'required|exists:store,store_id',
        ];
    }
}
