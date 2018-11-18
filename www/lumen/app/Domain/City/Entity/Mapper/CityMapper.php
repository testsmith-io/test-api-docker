<?php declare(strict_types=1);

namespace TestApi\Domain\City\Entity\Mapper;

use TestApi\Entity\Mapper\AbstractMapper;

class CityMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'id'        => 'city_id',
            'city'      => 'city',
            'countryId' => 'country_id',
        ];
    }
}
