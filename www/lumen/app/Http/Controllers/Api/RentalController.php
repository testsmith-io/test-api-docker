<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\Rental\Commands\AddRentalCommand;
use TestApi\Domain\Rental\Commands\UpdateRentalCommand;
use TestApi\Domain\Rental\Repository\RentalRepository;
use TestApi\Transformer\RentalTransformer;
use TestApi\Transformer\Transformer;

class RentalController extends AbstractController
{
    /**
     * @var \TestApi\Domain\Rental\Repository\RentalRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\Rental\Repository\RentalRepository $repository
     * @param \TestApi\Transformer\Transformer                   $transformer
     */
    public function __construct(RentalRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $rentalId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $rentalId): Response
    {
        $rental = $this->repository->get($rentalId);

        return $this->response($this->item($rental, RentalTransformer::class));
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
        $rentals  = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($rentals, RentalTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $rental = $commandBus->execute(new AddRentalCommand($request->post()));

        return $this->response($this->item($rental, RentalTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $rentalId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $rentalId, Request $request, CommandBus $commandBus): Response
    {
        $rental = $commandBus->execute(new UpdateRentalCommand($rentalId, $request->post()));

        return $this->response($this->item($rental, RentalTransformer::class));
    }

    /**
     * @param int $rentalId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $rentalId): Response
    {
        $this->repository->remove($rentalId);

        return $this->response();
    }
}
