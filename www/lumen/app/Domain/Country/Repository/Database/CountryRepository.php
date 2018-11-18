<?php declare(strict_types=1);

namespace TestApi\Domain\Country\Repository\Database;

use TestApi\Domain\Country\Repository\CountryRepository as CountryRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class CountryRepository extends AbstractDatabaseRepository implements CountryRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'country_id';
}
