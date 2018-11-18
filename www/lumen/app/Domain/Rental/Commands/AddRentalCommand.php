<?php declare(strict_types=1);

namespace TestApi\Domain\Rental\Commands;

use TestApi\Command\AbstractCommand;

class AddRentalCommand extends AbstractCommand
{
    /**
     * @var array
     */
    private $attributes;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->setAttributes($attributes);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
}
