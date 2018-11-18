<?php declare(strict_types=1);

namespace TestApi\Domain\Rental\Repository\Database;

use TestApi\Domain\Rental\Repository\RentalRepository as RentalRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class RentalRepository extends AbstractDatabaseRepository implements RentalRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'rental_id';
}
