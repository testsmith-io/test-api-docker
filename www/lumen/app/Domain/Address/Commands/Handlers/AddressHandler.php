<?php declare(strict_types=1);

namespace TestApi\Domain\Address\Commands\Handlers;

use TestApi\Domain\Address\Commands\AddAddressCommand;
use TestApi\Domain\Address\Commands\UpdateAddressCommand;
use TestApi\Domain\Address\Entity\Mapper\AddressMapper;
use TestApi\Domain\Address\Repository\AddressRepository;
use TestApi\Domain\Address\Validator\AddressValidator;
use TestApi\Entity\EntityInterface;

class AddressHandler
{
    /**
     * @var \TestApi\Domain\Address\Entity\Mapper\AddressMapper
     */
    private $addressMapper;

    /**
     * @var \TestApi\Domain\Address\Repository\AddressRepository
     */
    private $addressRepository;

    /**
     * @var \TestApi\Domain\Address\Validator\AddressValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Address\Entity\Mapper\AddressMapper  $mapper
     * @param \TestApi\Domain\Address\Repository\AddressRepository $repository
     * @param \TestApi\Domain\Address\Validator\AddressValidator   $validator
     */
    public function __construct(AddressMapper $mapper, AddressRepository $repository, AddressValidator $validator)
    {
        $this->addressMapper     = $mapper;
        $this->addressRepository = $repository;
        $this->validator         = $validator;
    }

    /**
     * @param \TestApi\Domain\Address\Commands\AddAddressCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddAddress(AddAddressCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->addressRepository->add($this->addressMapper->map($command->getAttributes()));

        $addressId = $this->addressRepository->lastInsertedId();
        $address   = $this->addressRepository->get($addressId);

        return $address;
    }

    /**
     * @param \TestApi\Domain\Address\Commands\UpdateAddressCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateAddress(UpdateAddressCommand $command): EntityInterface
    {
        $attributes = array_merge(['address_id' => $command->getAddressId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->addressRepository->update(
            $command->getAddressId(),
            $this->addressMapper->map($command->getAttributes())
        );
    }
}
