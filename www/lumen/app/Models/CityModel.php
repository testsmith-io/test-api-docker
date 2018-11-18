<?php declare(strict_types=1);

namespace TestApi\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property \TestApi\Models\CountryModel $country
 */
class CityModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $table = 'city';

    /**
     * @var string
     */
    protected $primaryKey = 'city_id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country(): HasOne
    {
        return $this->hasOne(CountryModel::class, 'country_id', 'country_id');
    }
}
