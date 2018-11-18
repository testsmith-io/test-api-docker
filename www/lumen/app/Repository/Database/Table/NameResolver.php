<?php declare(strict_types=1);

namespace TestApi\Repository\Database\Table;

use TestApi\Repository\RepositoryInterface;

interface NameResolver
{
    /**
     * @param \TestApi\Repository\RepositoryInterface $repository
     *
     * @return mixed
     */
    public function resolve(RepositoryInterface $repository);
}
