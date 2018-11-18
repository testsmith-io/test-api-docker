<?php declare(strict_types=1);

namespace TestApi\Transformer;

interface Transformer
{
    /**
     * @param mixed       $data
     * @param string|null $transformer
     *
     * @return array
     */
    public function item($data, string $transformer = null): array;

    /**
     * @param mixed       $data
     * @param string|null $transformer
     *
     * @return array
     */
    public function collection($data, string $transformer = null): array;
}
