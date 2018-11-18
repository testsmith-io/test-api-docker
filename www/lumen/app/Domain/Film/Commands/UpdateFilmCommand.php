<?php declare(strict_types=1);

namespace TestApi\Domain\Film\Commands;

use TestApi\Command\AbstractCommand;

class UpdateFilmCommand extends AbstractCommand
{
    /**
     * @var int
     */
    private $filmId;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param int   $filmId
     * @param array $attributes
     */
    public function __construct(int $filmId, array $attributes)
    {
        $this->filmId     = $filmId;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getFilmId(): int
    {
        return $this->filmId;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
