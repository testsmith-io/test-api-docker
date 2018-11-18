<?php declare(strict_types=1);

namespace TestApi\Domain\Store\Repository\Database;

use TestApi\Domain\Store\Repository\StoreRepository as StoreRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class StoreRepository extends AbstractDatabaseRepository implements StoreRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'store_id';
}
