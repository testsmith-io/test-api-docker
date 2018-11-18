<?php declare(strict_types=1);

namespace TestApi\Transformer;

use League\Fractal\TransformerAbstract;
use TestApi\Models\InventoryModel;

class InventoryTransformer extends TransformerAbstract
{
    /**
     * @param \TestApi\Models\InventoryModel $inventory
     *
     * @return array
     */
    public function transform(InventoryModel $inventory): array
    {
        return [
            'inventoryId' => $inventory->getAttribute('inventory_id'),
            'filmId'      => $inventory->getAttribute('film_id'),
            'storeId'     => $inventory->getAttribute('store_id'),
        ];
    }
}
