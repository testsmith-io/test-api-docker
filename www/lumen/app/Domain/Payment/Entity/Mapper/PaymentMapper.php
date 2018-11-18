<?php declare(strict_types=1);

namespace TestApi\Domain\Payment\Entity\Mapper;

use TestApi\Entity\Mapper\AbstractMapper;

class PaymentMapper extends AbstractMapper
{
    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'paymentId'   => 'payment_id',
            'customerId'  => 'customer_id',
            'staffId'     => 'staff_id',
            'rentalId'    => 'rental_id',
            'amount'      => 'amount',
            'paymentDate' => 'payment_date',
        ];
    }
}
