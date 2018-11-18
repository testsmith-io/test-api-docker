<?php declare(strict_types=1);

namespace TestApi\Domain\Film\Commands\Handlers;

use TestApi\Domain\Film\Commands\AddFilmCommand;
use TestApi\Domain\Film\Commands\UpdateFilmCommand;
use TestApi\Domain\Film\Entity\Mapper\FilmMapper;
use TestApi\Domain\Film\Repository\FilmRepository;
use TestApi\Domain\Film\Validator\FilmValidator;
use TestApi\Entity\EntityInterface;

class FilmHandler
{
    /**
     * @var \TestApi\Domain\Film\Entity\Mapper\FilmMapper
     */
    private $filmMapper;

    /**
     * @var \TestApi\Domain\Film\Repository\FilmRepository
     */
    private $filmRepository;

    /**
     * @var \TestApi\Domain\Film\Validator\FilmValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Film\Entity\Mapper\FilmMapper  $mapper
     * @param \TestApi\Domain\Film\Repository\FilmRepository $repository
     * @param \TestApi\Domain\Film\Validator\FilmValidator   $validator
     */
    public function __construct(FilmMapper $mapper, FilmRepository $repository, FilmValidator $validator)
    {
        $this->filmMapper     = $mapper;
        $this->filmRepository = $repository;
        $this->validator      = $validator;
    }

    /**
     * @param \TestApi\Domain\Film\Commands\AddFilmCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     */
    public function handleAddFilm(AddFilmCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->filmRepository->add($this->filmMapper->map($command->getAttributes()));

        $filmId = $this->filmRepository->lastInsertedId();
        $film   = $this->filmRepository->get($filmId);

        return $film;
    }


    /**
     * @param \TestApi\Domain\Film\Commands\UpdateFilmCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdateFilm(UpdateFilmCommand $command): EntityInterface
    {
        $attributes = array_merge(['film_id' => $command->getFilmId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->filmRepository->update(
            $command->getFilmId(),
            $this->filmMapper->map($command->getAttributes())
        );
    }
}
