<?php declare(strict_types=1);

namespace TestApi\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property \TestApi\Models\CityModel $city
 */
class AddressModel extends AbstractModel
{
    protected $table = 'address';

    public function city(): HasOne
    {
        return $this->hasOne(CityModel::class, 'city_id', 'city_id');
    }
}
