<?php declare(strict_types=1);

namespace TestApi\Domain\Rental\Entity\Mapper;

use TestApi\Entity\Mapper\AbstractMapper;

class RentalMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'rentalId'    => 'rental_id',
            'rentalDate'  => 'rental_date',
            'inventoryId' => 'inventory_id',
            'customerId'  => 'customer_id',
            'returnDate'  => 'return_date',
            'staffId'     => 'staff_id',
        ];
    }
}
