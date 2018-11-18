<?php declare(strict_types=1);

namespace TestApi\Models;

use Illuminate\Database\Eloquent\Model;
use TestApi\Entity\EntityInterface;

class AbstractModel extends Model implements EntityInterface
{
}
