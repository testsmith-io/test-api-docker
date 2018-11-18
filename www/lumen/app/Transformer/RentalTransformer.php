<?php declare(strict_types=1);

namespace TestApi\Transformer;

use League\Fractal\TransformerAbstract;
use TestApi\Models\RentalModel;

class RentalTransformer extends TransformerAbstract
{
    /**
     * @param \TestApi\Models\RentalModel $rental
     *
     * @return array
     */
    public function transform(RentalModel $rental): array
    {
        return [
            'rentalId'    => $rental->getAttribute('rental_id'),
            'rentalDate'  => $rental->getAttribute('rental_date'),
            'inventoryId' => $rental->getAttribute('inventory_id'),
            'customerId'  => $rental->getAttribute('customer_id'),
            'returnDate'  => $rental->getAttribute('return_date'),
            'staffId'     => $rental->getAttribute('staff_id'),
        ];
    }
}
