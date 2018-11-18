<?php declare(strict_types=1);

namespace TestApi\Entity;

use Illuminate\Database\Eloquent\Model;
use TestApi\Exceptions\UnexpectedValueException;

class IlluminateFactoryAdapter implements FactoryInterface
{

    /**
     * @param string $resource
     * @param array  $arguments
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\UnexpectedValueException
     */
    public function create(string $resource, array $arguments = []): EntityInterface
    {
        $model = $this->getModel($resource)->forceFill($arguments);
        if (!$model instanceof EntityInterface) {
            throw new UnexpectedValueException();
        }

        return $model;
    }

    /**
     * @param string $resource
     * @param array  $items
     *
     * @return array
     */
    public function hydrate(string $resource, array $items): array
    {
        return array_map(
            function ($item) use ($resource) {
                if ($item instanceof EntityInterface) {
                    return $item;
                }

                return $this->create($resource, (array) $item);
            },
            $items
        );
    }

    /**
     * @param string $resource
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getModel(string $resource): Model
    {
        $model = 'TestApi\Models\\' . ucfirst($resource) . 'Model';

        return new $model();
    }
}
