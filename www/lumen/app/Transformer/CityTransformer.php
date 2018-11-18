<?php declare(strict_types=1);

namespace TestApi\Transformer;

use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract;
use TestApi\Models\CityModel;

class CityTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'country',
    ];

    /**
     * @param \TestApi\Models\CityModel $city
     *
     * @return array
     */
    public function transform(CityModel $city): array
    {
        return [
            'cityId'    => $city->getAttribute('city_id'),
            'city'      => $city->getAttribute('city'),
            'countryId' => $city->getAttribute('country_id'),
        ];
    }

    /**
     * @param \TestApi\Models\CityModel $city
     *
     * @return \League\Fractal\Resource\ResourceAbstract
     */
    public function includeCountry(CityModel $city): ResourceAbstract
    {
        $country = $city->country;

        return $this->item($country, new CountryTransformer());
    }
}
