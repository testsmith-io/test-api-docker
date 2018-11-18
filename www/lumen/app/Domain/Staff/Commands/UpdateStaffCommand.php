<?php declare(strict_types=1);

namespace TestApi\Domain\Staff\Commands;

use TestApi\Command\AbstractCommand;

class UpdateStaffCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $staffId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $staffId
     * @param array $attributes
     */
    public function __construct(int $staffId, array $attributes)
    {
        $this->staffId    = $staffId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getStaffId(): int
    {
        return $this->staffId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
