<?php declare(strict_types=1);

namespace TestApi\Domain\Language\Commands\Handlers;

use TestApi\Domain\Language\Commands\AddLanguageCommand;
use TestApi\Domain\Language\Commands\UpdateLanguageCommand;
use TestApi\Domain\Language\Entity\Mapper\LanguageMapper;
use TestApi\Domain\Language\Repository\LanguageRepository;
use TestApi\Domain\Language\Validator\LanguageValidator;
use TestApi\Entity\EntityInterface;

class LanguageHandler
{
    /**
     * @var \TestApi\Domain\Language\Entity\Mapper\LanguageMapper
     */
    private $languageMapper;

    /**
     * @var \TestApi\Domain\Language\Repository\LanguageRepository
     */
    private $languageRepository;

    /**
     * @var \TestApi\Domain\Language\Validator\LanguageValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Language\Entity\Mapper\LanguageMapper  $mapper
     * @param \TestApi\Domain\Language\Repository\LanguageRepository $repository
     * @param \TestApi\Domain\Language\Validator\LanguageValidator   $validator
     */
    public function __construct(LanguageMapper $mapper, LanguageRepository $repository, LanguageValidator $validator)
    {
        $this->languageMapper     = $mapper;
        $this->languageRepository = $repository;
        $this->validator          = $validator;
    }

    /**
     * @param \TestApi\Domain\Language\Commands\AddLanguageCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddLanguage(AddLanguageCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->languageRepository->add($this->languageMapper->map($command->getAttributes()));

        $languageId = $this->languageRepository->lastInsertedId();
        $language   = $this->languageRepository->get($languageId);

        return $language;
    }

    /**
     * @param \TestApi\Domain\Language\Commands\UpdateLanguageCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateLanguage(UpdateLanguageCommand $command): EntityInterface
    {
        $attributes = array_merge(['language_id' => $command->getLanguageId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->languageRepository->update(
            $command->getLanguageId(),
            $this->languageMapper->map($command->getAttributes())
        );
    }
}
