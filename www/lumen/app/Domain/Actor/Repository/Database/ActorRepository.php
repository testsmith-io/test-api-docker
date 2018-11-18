<?php declare(strict_types=1);

namespace TestApi\Domain\Actor\Repository\Database;

use TestApi\Domain\Actor\Repository\ActorRepository as ActorRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class ActorRepository extends AbstractDatabaseRepository implements ActorRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'actor_id';
}
