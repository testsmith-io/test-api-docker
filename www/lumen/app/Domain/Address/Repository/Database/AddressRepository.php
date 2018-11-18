<?php declare(strict_types=1);

namespace TestApi\Domain\Address\Repository\Database;

use TestApi\Domain\Address\Repository\AddressRepository as AddressRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class AddressRepository extends AbstractDatabaseRepository implements AddressRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'address_id';
}
