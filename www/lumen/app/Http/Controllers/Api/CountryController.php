<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\Country\Commands\AddCountryCommand;
use TestApi\Domain\Country\Commands\UpdateCountryCommand;
use TestApi\Domain\Country\Repository\CountryRepository;
use TestApi\Transformer\CountryTransformer;
use TestApi\Transformer\Transformer;

class CountryController extends AbstractController
{
    /**
     * @var \TestApi\Domain\Country\Repository\CountryRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\Country\Repository\CountryRepository $repository
     * @param \TestApi\Transformer\Transformer                     $transformer
     */
    public function __construct(CountryRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $countryId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $countryId): Response
    {
        $country = $this->repository->get($countryId);

        return $this->response($this->item($country, CountryTransformer::class));
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
        $countries = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($countries, CountryTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $country = $commandBus->execute(new AddCountryCommand($request->post()));

        return $this->response($this->item($country, CountryTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $countryId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $countryId, Request $request, CommandBus $commandBus): Response
    {
        $country = $commandBus->execute(new UpdateCountryCommand($countryId, $request->post()));

        return $this->response($this->item($country, CountryTransformer::class));
    }

    /**
     * @param int $countryId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $countryId): Response
    {
        $this->repository->remove($countryId);

        return $this->response();
    }
}
