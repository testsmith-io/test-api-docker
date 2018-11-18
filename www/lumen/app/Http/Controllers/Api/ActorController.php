<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\Actor\Commands\AddActorCommand;
use TestApi\Domain\Actor\Commands\UpdateActorCommand;
use TestApi\Domain\Actor\Repository\ActorRepository;
use TestApi\Transformer\ActorTransformer;
use TestApi\Transformer\Transformer;

class ActorController extends AbstractController
{
    /**
     * @var \TestApi\Domain\Actor\Repository\ActorRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\Actor\Repository\ActorRepository $repository
     * @param \TestApi\Transformer\Transformer                 $transformer
     */
    public function __construct(ActorRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $actorId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $actorId): Response
    {
        $actor = $this->repository->get($actorId);

        return $this->response($this->item($actor, ActorTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page     = (int)$request->query('page', 1);
        $pageSize = (int)$request->query('page_size', 15);
        $items    = $this->repository->all($page, $pageSize);
        $total    = $this->repository->count();
        $actors   = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($actors, ActorTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $actor = $commandBus->execute(new AddActorCommand($request->post()));

        return $this->response($this->item($actor, ActorTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $actorId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $actorId, Request $request, CommandBus $commandBus): Response
    {
        $actor = $commandBus->execute(new UpdateActorCommand($actorId, $request->post()));

        return $this->response($this->item($actor, ActorTransformer::class));
    }

    /**
     * @param int $actorId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $actorId): Response
    {
        $this->repository->remove($actorId);

        return $this->response();
    }
}
