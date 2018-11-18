<?php declare(strict_types=1);

namespace TestApi\Domain\Customer\Repository\Database;

use TestApi\Domain\Customer\Repository\CustomerRepository as CustomerRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class CustomerRepository extends AbstractDatabaseRepository implements CustomerRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'customer_id';
}
