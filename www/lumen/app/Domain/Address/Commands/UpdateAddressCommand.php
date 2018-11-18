<?php declare(strict_types=1);

namespace TestApi\Domain\Address\Commands;

use TestApi\Command\AbstractCommand;

class UpdateAddressCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $addressId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $addressId
     * @param array $attributes
     */
    public function __construct(int $addressId, array $attributes)
    {
        $this->addressId  = $addressId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getAddressId(): int
    {
        return $this->addressId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
