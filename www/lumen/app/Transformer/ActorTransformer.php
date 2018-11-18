<?php declare(strict_types=1);

namespace TestApi\Transformer;

use League\Fractal\TransformerAbstract;
use TestApi\Models\ActorModel;

class ActorTransformer extends TransformerAbstract
{
    /**
     * @param \TestApi\Models\ActorModel $actor
     *
     * @return array
     */
    public function transform(ActorModel $actor): array
    {
        return [
            'actorId'   => $actor->getAttribute('actor_id'),
            'firstName' => $actor->getAttribute('first_name'),
            'lastName'  => $actor->getAttribute('last_name'),
        ];
    }
}
