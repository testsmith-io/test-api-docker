<?php declare(strict_types=1);

namespace TestApi\Domain\Inventory\Commands\Handlers;

use TestApi\Domain\Inventory\Commands\AddInventoryCommand;
use TestApi\Domain\Inventory\Commands\UpdateInventoryCommand;
use TestApi\Domain\Inventory\Entity\Mapper\InventoryMapper;
use TestApi\Domain\Inventory\Repository\InventoryRepository;
use TestApi\Domain\Inventory\Validator\InventoryValidator;
use TestApi\Entity\EntityInterface;

class InventoryHandler
{
    /**
     * @var \TestApi\Domain\Inventory\Entity\Mapper\InventoryMapper
     */
    private $inventoryMapper;

    /**
     * @var \TestApi\Domain\Inventory\Repository\InventoryRepository
     */
    private $inventoryRepository;

    /**
     * @var \TestApi\Domain\Inventory\Validator\InventoryValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Inventory\Entity\Mapper\InventoryMapper  $mapper
     * @param \TestApi\Domain\Inventory\Repository\InventoryRepository $repository
     * @param \TestApi\Domain\Inventory\Validator\InventoryValidator   $validator
     */
    public function __construct(InventoryMapper $mapper, InventoryRepository $repository, InventoryValidator $validator)
    {
        $this->inventoryMapper     = $mapper;
        $this->inventoryRepository = $repository;
        $this->validator           = $validator;
    }

    /**
     * @param \TestApi\Domain\Inventory\Commands\AddInventoryCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddInventory(AddInventoryCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->inventoryRepository->add($this->inventoryMapper->map($command->getAttributes()));

        $inventoryId = $this->inventoryRepository->lastInsertedId();
        $inventory   = $this->inventoryRepository->get($inventoryId);

        return $inventory;
    }


    /**
     * @param \TestApi\Domain\Inventory\Commands\UpdateInventoryCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateInventory(UpdateInventoryCommand $command): EntityInterface
    {
        $attributes = array_merge(['inventory_id' => $command->getInventoryId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->inventoryRepository->update(
            $command->getInventoryId(),
            $this->inventoryMapper->map($command->getAttributes())
        );
    }
}
