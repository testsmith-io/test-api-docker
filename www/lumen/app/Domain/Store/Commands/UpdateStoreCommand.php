<?php declare(strict_types=1);

namespace TestApi\Domain\Store\Commands;

use TestApi\Command\AbstractCommand;

class UpdateStoreCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $storeId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $storeId
     * @param array $attributes
     */
    public function __construct(int $storeId, array $attributes)
    {
        $this->storeId    = $storeId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getStoreId(): int
    {
        return $this->storeId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
