<?php declare(strict_types=1);

namespace TestApi\Entity;

use JsonSerializable;

interface EntityInterface extends JsonSerializable
{
    /**
     * @param array $data
     *
     * @return \TestApi\Entity\EntityInterface
     */
    public function fill(array $data);
}
