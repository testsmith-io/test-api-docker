<?php declare(strict_types=1);

namespace TestApi\Domain\Rental\Commands;

use TestApi\Command\AbstractCommand;

class UpdateRentalCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $rentalId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $rentalId
     * @param array $attributes
     */
    public function __construct(int $rentalId, array $attributes)
    {
        $this->rentalId   = $rentalId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getRentalId(): int
    {
        return $this->rentalId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
