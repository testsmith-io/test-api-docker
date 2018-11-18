<?php declare(strict_types=1);

namespace TestApi\Transformer;

use League\Fractal\TransformerAbstract;
use TestApi\Models\CustomerModel;

class CustomerTransformer extends TransformerAbstract
{
    /**
     * @param \TestApi\Models\CustomerModel $customer
     *
     * @return array
     */
    public function transform(CustomerModel $customer): array
    {
        return [
            'customerId' => $customer->getAttribute('customer_id'),
            'storeId'    => $customer->getAttribute('store_id'),
            'firstName'  => $customer->getAttribute('first_name'),
            'lastName'   => $customer->getAttribute('last_name'),
            'email'      => $customer->getAttribute('email'),
            'addressId'  => $customer->getAttribute('address_id'),
            'active'     => $customer->getAttribute('active'),
            'createDate' => $customer->getAttribute('create_date'),
        ];
    }
}
