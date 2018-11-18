<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\Address\Commands\AddAddressCommand;
use TestApi\Domain\Address\Commands\UpdateAddressCommand;
use TestApi\Domain\Address\Repository\AddressRepository;
use TestApi\Transformer\AddressTransformer;
use TestApi\Transformer\Transformer;

class AddressController extends AbstractController
{
    /**
     * @var \TestApi\Domain\Address\Repository\AddressRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\Address\Repository\AddressRepository $repository
     * @param \TestApi\Transformer\Transformer                     $transformer
     */
    public function __construct(AddressRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $addressId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $addressId): Response
    {
        $address = $this->repository->get($addressId);

        return $this->response($this->item($address, AddressTransformer::class));
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
        $addresses = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($addresses, AddressTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $address = $commandBus->execute(new AddAddressCommand($request->post()));

        return $this->response($this->item($address, AddressTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $addressId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $addressId, Request $request, CommandBus $commandBus): Response
    {
        $address = $commandBus->execute(new UpdateAddressCommand($addressId, $request->post()));

        return $this->response($this->item($address, AddressTransformer::class));
    }

    /**
     * @param int $addressId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $addressId): Response
    {
        $this->repository->remove($addressId);

        return $this->response();
    }
}
