<?php declare(strict_types=1);

namespace TestApi\Domain\City\Commands\Handlers;

use TestApi\Domain\City\Commands\AddCityCommand;
use TestApi\Domain\City\Commands\UpdateCityCommand;
use TestApi\Domain\City\Entity\Mapper\CityMapper;
use TestApi\Domain\City\Repository\CityRepository;
use TestApi\Domain\City\Validator\CityValidator;
use TestApi\Entity\EntityInterface;

class CityHandler
{
    /**
     * @var \TestApi\Domain\City\Entity\Mapper\CityMapper
     */
    private $cityMapper;

    /**
     * @var \TestApi\Domain\City\Repository\CityRepository
     */
    private $cityRepository;

    /**
     * @var \TestApi\Domain\City\Validator\CityValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\City\Entity\Mapper\CityMapper  $mapper
     * @param \TestApi\Domain\City\Repository\CityRepository $repository
     * @param \TestApi\Domain\City\Validator\CityValidator   $validator
     */
    public function __construct(CityMapper $mapper, CityRepository $repository, CityValidator $validator)
    {
        $this->cityMapper     = $mapper;
        $this->cityRepository = $repository;
        $this->validator      = $validator;
    }

    /**
     * @param \TestApi\Domain\City\Commands\AddCityCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddCity(AddCityCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->cityRepository->add($this->cityMapper->map($command->getAttributes()));

        $cityId = $this->cityRepository->lastInsertedId();
        $city   = $this->cityRepository->get($cityId);

        return $city;
    }

    /**
     * @param \TestApi\Domain\City\Commands\UpdateCityCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateCity(UpdateCityCommand $command): EntityInterface
    {
        $attributes = array_merge(['city_id' => $command->getCityId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->cityRepository->update(
            $command->getCityId(),
            $this->cityMapper->map($command->getAttributes())
        );
    }
}
