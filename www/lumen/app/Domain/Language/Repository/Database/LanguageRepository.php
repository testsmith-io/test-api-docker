<?php declare(strict_types=1);

namespace TestApi\Domain\Language\Repository\Database;

use TestApi\Domain\Language\Repository\LanguageRepository as LanguageRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class LanguageRepository extends AbstractDatabaseRepository implements LanguageRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'language_id';
}
