<?php declare(strict_types=1);

namespace TestApi\Transformer;

use League\Fractal\TransformerAbstract;
use TestApi\Models\CountryModel;

class CountryTransformer extends TransformerAbstract
{
    /**
     * @param \TestApi\Models\CountryModel $country
     *
     * @return array
     */
    public function transform(CountryModel $country): array
    {
        return [
            'countryId' => $country->getAttribute('country_id'),
            'country'   => $country->getAttribute('country'),
        ];
    }
}
