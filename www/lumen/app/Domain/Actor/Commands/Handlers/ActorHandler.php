<?php declare(strict_types=1);

namespace TestApi\Domain\Actor\Commands\Handlers;

use TestApi\Domain\Actor\Commands\AddActorCommand;
use TestApi\Domain\Actor\Commands\UpdateActorCommand;
use TestApi\Domain\Actor\Entity\Mapper\ActorMapper;
use TestApi\Domain\Actor\Repository\ActorRepository;
use TestApi\Domain\Actor\Validator\ActorValidator;
use TestApi\Entity\EntityInterface;

class ActorHandler
{
    /**
     * @var \TestApi\Domain\Actor\Entity\Mapper\ActorMapper
     */
    private $actorMapper;

    /**
     * @var \TestApi\Domain\Actor\Repository\ActorRepository
     */
    private $actorRepository;

    /**
     * @var \TestApi\Domain\Actor\Validator\ActorValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Actor\Entity\Mapper\ActorMapper  $mapper
     * @param \TestApi\Domain\Actor\Repository\ActorRepository $repository
     * @param \TestApi\Domain\Actor\Validator\ActorValidator   $validator
     */
    public function __construct(ActorMapper $mapper, ActorRepository $repository, ActorValidator $validator)
    {
        $this->actorMapper     = $mapper;
        $this->actorRepository = $repository;
        $this->validator       = $validator;
    }

    /**
     * @param \TestApi\Domain\Actor\Commands\AddActorCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddActor(AddActorCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->actorRepository->add($this->actorMapper->map($command->getAttributes()));

        $actorId = $this->actorRepository->lastInsertedId();
        $actor   = $this->actorRepository->get($actorId);

        return $actor;
    }

    /**
     * @param \TestApi\Domain\Actor\Commands\UpdateActorCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateActor(UpdateActorCommand $command): EntityInterface
    {
        $attributes = array_merge(['actor_id' => $command->getActorId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->actorRepository->update(
            $command->getActorId(),
            $this->actorMapper->map($command->getAttributes())
        );
    }
}
