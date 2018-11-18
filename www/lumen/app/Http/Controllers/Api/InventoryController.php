<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\Inventory\Commands\AddInventoryCommand;
use TestApi\Domain\Inventory\Commands\UpdateInventoryCommand;
use TestApi\Domain\Inventory\Repository\InventoryRepository;
use TestApi\Transformer\InventoryTransformer;
use TestApi\Transformer\Transformer;

class InventoryController extends AbstractController
{
    /**
     * @var \TestApi\Domain\Inventory\Repository\InventoryRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\Inventory\Repository\InventoryRepository $repository
     * @param \TestApi\Transformer\Transformer                         $transformer
     */
    public function __construct(InventoryRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $inventoryId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $inventoryId): Response
    {
        $inventory = $this->repository->get($inventoryId);

        return $this->response($this->item($inventory, InventoryTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $page      = (int)$request->query('page', 1);
        $pageSize  = (int)$request->query('page_size', 15);
        $items     = $this->repository->all($page, $pageSize);
        $total     = $this->repository->count();
        $inventory = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($inventory, InventoryTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $inventory = $commandBus->execute(new AddInventoryCommand($request->post()));

        return $this->response($this->item($inventory, InventoryTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $inventoryId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $inventoryId, Request $request, CommandBus $commandBus): Response
    {
        $inventory = $commandBus->execute(new UpdateInventoryCommand($inventoryId, $request->post()));

        return $this->response($this->item($inventory, InventoryTransformer::class));
    }

    /**
     * @param int $inventoryId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $inventoryId): Response
    {
        $this->repository->remove($inventoryId);

        return $this->response();
    }
}
