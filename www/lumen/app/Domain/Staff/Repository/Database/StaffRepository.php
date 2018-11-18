<?php declare(strict_types=1);

namespace TestApi\Domain\Staff\Repository\Database;

use TestApi\Domain\Staff\Repository\StaffRepository as StaffRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class StaffRepository extends AbstractDatabaseRepository implements StaffRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'staff_id';
}
