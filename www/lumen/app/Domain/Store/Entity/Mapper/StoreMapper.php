<?php declare(strict_types=1);

namespace TestApi\Domain\Store\Entity\Mapper;

use TestApi\Entity\Mapper\AbstractMapper;

class StoreMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'storeId'        => 'store_id',
            'managerStaffId' => 'manager_staff_id',
            'addressId'      => 'address_id',
        ];
    }
}
