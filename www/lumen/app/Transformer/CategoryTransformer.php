<?php declare(strict_types=1);

namespace TestApi\Transformer;

use League\Fractal\TransformerAbstract;
use TestApi\Models\CategoryModel;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * @param \TestApi\Models\CategoryModel $category
     *
     * @return array
     */
    public function transform(CategoryModel $category): array
    {
        return [
            'categoryId' => $category->getAttribute('category_id'),
            'name'       => $category->getAttribute('name'),
        ];
    }
}
