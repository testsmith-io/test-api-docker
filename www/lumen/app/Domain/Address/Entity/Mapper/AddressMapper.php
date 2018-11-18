<?php declare(strict_types=1);

namespace TestApi\Domain\Address\Entity\Mapper;

use TestApi\Entity\Mapper\AbstractMapper;

class AddressMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'id'         => 'address_id',
            'address'    => 'address',
            'address2'   => 'address2',
            'district'   => 'district',
            'cityId'     => 'city_id',
            'postalCode' => 'postal_code',
            'phone'      => 'phone',
        ];
    }
}
