<?php declare(strict_types=1);

namespace TestApi\Domain\Customer\Entity\Mapper;

use TestApi\Entity\Mapper\AbstractMapper;

class CustomerMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'customerId' => 'customer_id',
            'storeId'    => 'store_id',
            'firstName'  => 'first_name',
            'lastName'   => 'last_name',
            'email'      => 'email',
            'addressId'  => 'address_id',
            'active'     => 'active',
            'createDate' => 'create_date',
        ];
    }
}
