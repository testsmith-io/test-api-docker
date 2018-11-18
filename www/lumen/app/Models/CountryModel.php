<?php declare(strict_types=1);

namespace TestApi\Models;

use Illuminate\Database\Eloquent\Model;
use TestApi\Entity\EntityInterface;

class CountryModel extends Model implements EntityInterface
{
    /**
     * @var string
     */
    protected $table = 'country';

    /**
     * @var string
     */
    protected $primaryKey = 'country_id';
}
