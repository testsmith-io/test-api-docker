<?php declare(strict_types=1);

namespace TestApi\Domain\Customer\Commands\Handlers;

use TestApi\Domain\Customer\Commands\AddCustomerCommand;
use TestApi\Domain\Customer\Commands\UpdateCustomerCommand;
use TestApi\Domain\Customer\Entity\Mapper\CustomerMapper;
use TestApi\Domain\Customer\Repository\CustomerRepository;
use TestApi\Domain\Customer\Validator\CustomerValidator;
use TestApi\Entity\EntityInterface;

class CustomerHandler
{
    /**
     * @var \TestApi\Domain\Customer\Entity\Mapper\CustomerMapper
     */
    private $customerMapper;

    /**
     * @var \TestApi\Domain\Customer\Repository\CustomerRepository
     */
    private $customerRepository;

    /**
     * @var \TestApi\Domain\Customer\Validator\CustomerValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Customer\Entity\Mapper\CustomerMapper  $mapper
     * @param \TestApi\Domain\Customer\Repository\CustomerRepository $repository
     * @param \TestApi\Domain\Customer\Validator\CustomerValidator   $validator
     */
    public function __construct(CustomerMapper $mapper, CustomerRepository $repository, CustomerValidator $validator)
    {
        $this->customerMapper     = $mapper;
        $this->customerRepository = $repository;
        $this->validator          = $validator;
    }

    /**
     * @param \TestApi\Domain\Customer\Commands\AddCustomerCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddCustomer(AddCustomerCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->customerRepository->add($this->customerMapper->map($command->getAttributes()));

        $customerId = $this->customerRepository->lastInsertedId();
        $customer   = $this->customerRepository->get($customerId);

        return $customer;
    }


    /**
     * @param \TestApi\Domain\Customer\Commands\UpdateCustomerCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateCustomer(UpdateCustomerCommand $command): EntityInterface
    {
        $attributes = array_merge(['customer_id' => $command->getCustomerId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->customerRepository->update(
            $command->getCustomerId(),
            $this->customerMapper->map($command->getAttributes())
        );
    }
}
