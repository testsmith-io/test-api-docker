<?php declare(strict_types=1);

namespace TestApi\Domain\Actor\Commands;

use TestApi\Command\AbstractCommand;

class UpdateActorCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $actorId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $actorId
     * @param array $attributes
     */
    public function __construct(int $actorId, array $attributes)
    {
        $this->actorId    = $actorId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getActorId(): int
    {
        return $this->actorId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
