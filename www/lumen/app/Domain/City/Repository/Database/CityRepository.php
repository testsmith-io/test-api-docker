<?php declare(strict_types=1);

namespace TestApi\Domain\City\Repository\Database;

use TestApi\Domain\City\Repository\CityRepository as CityRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class CityRepository extends AbstractDatabaseRepository implements CityRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'city_id';
}
