<?php declare(strict_types=1);

namespace TestApi\Domain\Country\Commands\Handlers;

use TestApi\Domain\Country\Commands\AddCountryCommand;
use TestApi\Domain\Country\Commands\UpdateCountryCommand;
use TestApi\Domain\Country\Entity\Mapper\CountryMapper;
use TestApi\Domain\Country\Repository\CountryRepository;
use TestApi\Domain\Country\Validator\CountryValidator;
use TestApi\Entity\EntityInterface;

class CountryHandler
{
    /**
     * @var \TestApi\Domain\Country\Entity\Mapper\CountryMapper
     */
    private $countryMapper;

    /**
     * @var \TestApi\Domain\Country\Repository\CountryRepository
     */
    private $countryRepository;

    /**
     * @var \TestApi\Domain\Country\Validator\CountryValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Country\Entity\Mapper\CountryMapper  $mapper
     * @param \TestApi\Domain\Country\Repository\CountryRepository $repository
     * @param \TestApi\Domain\Country\Validator\CountryValidator   $validator
     */
    public function __construct(CountryMapper $mapper, CountryRepository $repository, CountryValidator $validator)
    {
        $this->countryMapper     = $mapper;
        $this->countryRepository = $repository;
        $this->validator         = $validator;
    }

    /**
     * @param \TestApi\Domain\Country\Commands\AddCountryCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddCountry(AddCountryCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->countryRepository->add($this->countryMapper->map($command->getAttributes()));

        $countryId = $this->countryRepository->lastInsertedId();
        $country   = $this->countryRepository->get($countryId);

        return $country;
    }

    /**
     * @param \TestApi\Domain\Country\Commands\UpdateCountryCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateCountry(UpdateCountryCommand $command): EntityInterface
    {
        $attributes = array_merge(['country_id' => $command->getCountryId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->countryRepository->update(
            $command->getCountryId(),
            $this->countryMapper->map($command->getAttributes())
        );
    }
}
