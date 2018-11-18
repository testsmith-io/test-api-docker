<?php declare(strict_types=1);

namespace TestApi\Command\Bus;

use TestApi\Command\Command;

interface CommandBus
{
    /**
     * @param \TestApi\Command\Command $command
     *
     * @return mixed
     */
    public function execute(Command $command);
}
