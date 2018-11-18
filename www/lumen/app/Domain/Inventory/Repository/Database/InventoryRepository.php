<?php declare(strict_types=1);

namespace TestApi\Domain\Inventory\Repository\Database;

use TestApi\Domain\Inventory\Repository\InventoryRepository as InventoryRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class InventoryRepository extends AbstractDatabaseRepository implements InventoryRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'inventory_id';
}
