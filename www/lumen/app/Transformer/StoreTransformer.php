<?php declare(strict_types=1);

namespace TestApi\Transformer;

use League\Fractal\TransformerAbstract;
use TestApi\Models\StoreModel;

class StoreTransformer extends TransformerAbstract
{
    /**
     * @param \TestApi\Models\StoreModel $store
     *
     * @return array
     */
    public function transform(StoreModel $store): array
    {
        return [
            'storeId'        => $store->getAttribute('store_id'),
            'managerStaffId' => $store->getAttribute('manager_staff_id'),
            'addressId'      => $store->getAttribute('address_id'),
        ];
    }
}
