<?php declare(strict_types=1);

namespace TestApi\Transformer;

use League\Fractal\TransformerAbstract;
use TestApi\Models\StaffModel;

class StaffTransformer extends TransformerAbstract
{
    /**
     * @param \TestApi\Models\StaffModel $staff
     *
     * @return array
     */
    public function transform(StaffModel $staff): array
    {
        return [
            'staffId'   => $staff->getAttribute('staff_id'),
            'firstName' => $staff->getAttribute('first_name'),
            'lastName'  => $staff->getAttribute('last_name'),
            'addressId' => $staff->getAttribute('address_id'),
//            'picture'   => $staff->getAttribute('picture'),
            'email'     => $staff->getAttribute('email'),
            'storeId'   => $staff->getAttribute('store_id'),
            'active'    => $staff->getAttribute('active'),
            'username'  => $staff->getAttribute('username'),
            'password'  => $staff->getAttribute('password'),
        ];
    }
}
