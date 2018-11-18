<?php declare(strict_types=1);

namespace TestApi\Domain\Store\Commands\Handlers;

use TestApi\Domain\Store\Commands\AddStoreCommand;
use TestApi\Domain\Store\Commands\UpdateStoreCommand;
use TestApi\Domain\Store\Entity\Mapper\StoreMapper;
use TestApi\Domain\Store\Repository\StoreRepository;
use TestApi\Domain\Store\Validator\StoreValidator;
use TestApi\Entity\EntityInterface;

class StoreHandler
{
    /**
     * @var \TestApi\Domain\Store\Entity\Mapper\StoreMapper
     */
    private $storeMapper;

    /**
     * @var \TestApi\Domain\Store\Repository\StoreRepository
     */
    private $storeRepository;

    /**
     * @var \TestApi\Domain\Store\Validator\StoreValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Store\Entity\Mapper\StoreMapper  $mapper
     * @param \TestApi\Domain\Store\Repository\StoreRepository $repository
     * @param \TestApi\Domain\Store\Validator\StoreValidator   $validator
     */
    public function __construct(StoreMapper $mapper, StoreRepository $repository, StoreValidator $validator)
    {
        $this->storeMapper     = $mapper;
        $this->storeRepository = $repository;
        $this->validator       = $validator;
    }

    /**
     * @param \TestApi\Domain\Store\Commands\AddStoreCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddStore(AddStoreCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->storeRepository->add($this->storeMapper->map($command->getAttributes()));

        $storeId = $this->storeRepository->lastInsertedId();
        $store   = $this->storeRepository->get($storeId);

        return $store;
    }


    /**
     * @param \TestApi\Domain\Store\Commands\UpdateStoreCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateStore(UpdateStoreCommand $command): EntityInterface
    {
        $attributes = array_merge(['store_id' => $command->getStoreId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->storeRepository->update(
            $command->getStoreId(),
            $this->storeMapper->map($command->getAttributes())
        );
    }
}
