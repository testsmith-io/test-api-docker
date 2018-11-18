<?php declare(strict_types=1);

namespace TestApi\Domain\Payment\Repository\Database;

use TestApi\Domain\Payment\Repository\PaymentRepository as PaymentRepositoryInterface;
use TestApi\Repository\Database\AbstractDatabaseRepository;

class PaymentRepository extends AbstractDatabaseRepository implements PaymentRepositoryInterface
{
    /**
     * @var string
     */
    protected $primaryKey = 'payment_id';
}
