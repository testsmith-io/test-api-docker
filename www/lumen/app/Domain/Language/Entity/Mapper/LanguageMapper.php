<?php declare(strict_types=1);

namespace TestApi\Domain\Language\Entity\Mapper;

use TestApi\Entity\Mapper\AbstractMapper;

class LanguageMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'id'   => 'language_id',
            'name' => 'name',
        ];
    }
}
