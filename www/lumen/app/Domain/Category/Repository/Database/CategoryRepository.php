<?php declare(strict_types=1);

namespace TestApi\Domain\Category\Repository\Database;

use TestApi\Domain\Category\Repository\CategoryRepository as CategoryRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class CategoryRepository extends AbstractDatabaseRepository implements CategoryRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'category_id';
}
