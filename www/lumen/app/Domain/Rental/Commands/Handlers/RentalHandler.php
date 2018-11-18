<?php declare(strict_types=1);

namespace TestApi\Domain\Rental\Commands\Handlers;

use TestApi\Domain\Rental\Commands\AddRentalCommand;
use TestApi\Domain\Rental\Commands\UpdateRentalCommand;
use TestApi\Domain\Rental\Entity\Mapper\RentalMapper;
use TestApi\Domain\Rental\Repository\RentalRepository;
use TestApi\Domain\Rental\Validator\RentalValidator;
use TestApi\Entity\EntityInterface;

class RentalHandler
{
    /**
     * @var \TestApi\Domain\Rental\Entity\Mapper\RentalMapper
     */
    private $rentalMapper;

    /**
     * @var \TestApi\Domain\Rental\Repository\RentalRepository
     */
    private $rentalRepository;

    /**
     * @var \TestApi\Domain\Rental\Validator\RentalValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Rental\Entity\Mapper\RentalMapper  $mapper
     * @param \TestApi\Domain\Rental\Repository\RentalRepository $repository
     * @param \TestApi\Domain\Rental\Validator\RentalValidator   $validator
     */
    public function __construct(RentalMapper $mapper, RentalRepository $repository, RentalValidator $validator)
    {
        $this->rentalMapper     = $mapper;
        $this->rentalRepository = $repository;
        $this->validator        = $validator;
    }

    /**
     * @param \TestApi\Domain\Rental\Commands\AddRentalCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddRental(AddRentalCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->rentalRepository->add($this->rentalMapper->map($command->getAttributes()));

        $rentalId = $this->rentalRepository->lastInsertedId();
        $rental   = $this->rentalRepository->get($rentalId);

        return $rental;
    }


    /**
     * @param \TestApi\Domain\Rental\Commands\UpdateRentalCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateRental(UpdateRentalCommand $command): EntityInterface
    {
        $attributes = array_merge(['rental_id' => $command->getRentalId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->rentalRepository->update(
            $command->getRentalId(),
            $this->rentalMapper->map($command->getAttributes())
        );
    }
}
