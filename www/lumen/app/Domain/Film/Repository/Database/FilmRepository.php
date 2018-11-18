<?php declare(strict_types=1);

namespace TestApi\Domain\Film\Repository\Database;

use TestApi\Domain\Film\Repository\FilmRepository as FilmRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class FilmRepository extends AbstractDatabaseRepository implements FilmRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'film_id';
}
