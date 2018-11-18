<?php declare(strict_types=1);

namespace TestApi\Entity\Mapper;

abstract class AbstractMapper
{
    /**
     * @return array
     */
    abstract protected function getMapping(): array;

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function map(array $attributes): array
    {
        $mapping = $this->getMapping();
        $result  = [];
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $mapping)) {
                $result[$mapping[$key]] = $value;
            }
        }

        return $result;
    }
}
