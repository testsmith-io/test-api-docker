<?php declare(strict_types=1);

namespace TestApi\Domain\Staff\Entity\Mapper;

use TestApi\Entity\Mapper\AbstractMapper;

class StaffMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'staffId'   => 'staff_id',
            'firstName' => 'first_name',
            'lastName'  => 'last_name',
            'addressId' => 'address_id',
            'picture'   => 'picture',
            'email'     => 'email',
            'storeId'   => 'store_id',
            'active'    => 'active',
            'username'  => 'username',
            'password'  => 'password',
        ];
    }
}
