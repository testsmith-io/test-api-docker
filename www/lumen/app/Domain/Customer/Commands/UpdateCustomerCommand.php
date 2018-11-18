<?php declare(strict_types=1);

namespace TestApi\Domain\Customer\Commands;

use TestApi\Command\AbstractCommand;

class UpdateCustomerCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $customerId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $customerId
     * @param array $attributes
     */
    public function __construct(int $customerId, array $attributes)
    {
        $this->customerId = $customerId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
