<?php declare(strict_types=1);

namespace TestApi\Domain\Staff\Commands\Handlers;

use TestApi\Domain\Staff\Commands\AddStaffCommand;
use TestApi\Domain\Staff\Commands\UpdateStaffCommand;
use TestApi\Domain\Staff\Entity\Mapper\StaffMapper;
use TestApi\Domain\Staff\Repository\StaffRepository;
use TestApi\Domain\Staff\Validator\StaffValidator;
use TestApi\Entity\EntityInterface;

class StaffHandler
{
    /**
     * @var \TestApi\Domain\Staff\Entity\Mapper\StaffMapper
     */
    private $staffMapper;

    /**
     * @var \TestApi\Domain\Staff\Repository\StaffRepository
     */
    private $staffRepository;

    /**
     * @var \TestApi\Domain\Staff\Validator\StaffValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Staff\Entity\Mapper\StaffMapper  $mapper
     * @param \TestApi\Domain\Staff\Repository\StaffRepository $repository
     * @param \TestApi\Domain\Staff\Validator\StaffValidator   $validator
     */
    public function __construct(StaffMapper $mapper, StaffRepository $repository, StaffValidator $validator)
    {
        $this->staffMapper     = $mapper;
        $this->staffRepository = $repository;
        $this->validator       = $validator;
    }

    /**
     * @param \TestApi\Domain\Staff\Commands\AddStaffCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddStaff(AddStaffCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->staffRepository->add($this->staffMapper->map($command->getAttributes()));

        $staffId = $this->staffRepository->lastInsertedId();
        $staff   = $this->staffRepository->get($staffId);

        return $staff;
    }


    /**
     * @param \TestApi\Domain\Staff\Commands\UpdateStaffCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateStaff(UpdateStaffCommand $command): EntityInterface
    {
        $attributes = array_merge(['staff_id' => $command->getStaffId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->staffRepository->update(
            $command->getStaffId(),
            $this->staffMapper->map($command->getAttributes())
        );
    }
}
