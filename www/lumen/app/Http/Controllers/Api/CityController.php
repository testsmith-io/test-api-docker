<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\City\Commands\AddCityCommand;
use TestApi\Domain\City\Commands\UpdateCityCommand;
use TestApi\Domain\City\Repository\CityRepository;
use TestApi\Transformer\CityTransformer;
use TestApi\Transformer\Transformer;

class CityController extends AbstractController
{
    /**
     * @var \TestApi\Domain\City\Repository\CityRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\City\Repository\CityRepository $repository
     * @param \TestApi\Transformer\Transformer               $transformer
     */
    public function __construct(CityRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $cityId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $cityId): Response
    {
        $city = $this->repository->get($cityId);

        return $this->response($this->item($city, CityTransformer::class));
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
        $cities   = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($cities, CityTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $city = $commandBus->execute(new AddCityCommand($request->post()));

        return $this->response($this->item($city, CityTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $cityId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $cityId, Request $request, CommandBus $commandBus): Response
    {
        $city = $commandBus->execute(new UpdateCityCommand($cityId, $request->post()));

        return $this->response($this->item($city, CityTransformer::class));
    }

    /**
     * @param int $cityId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $cityId): Response
    {
        $this->repository->remove($cityId);

        return $this->response();
    }
}
