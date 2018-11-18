<?php declare(strict_types=1);

namespace TestApi\Domain\Inventory\Commands;

use TestApi\Command\AbstractCommand;

class UpdateInventoryCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $inventoryId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $inventoryId
     * @param array $attributes
     */
    public function __construct(int $inventoryId, array $attributes)
    {
        $this->inventoryId = $inventoryId;
        $this->attributes  = $attributes;
    }

    /**
     * @return int
     */
    public function getInventoryId(): int
    {
        return $this->inventoryId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
