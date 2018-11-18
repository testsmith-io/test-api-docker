<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\Customer\Commands\AddCustomerCommand;
use TestApi\Domain\Customer\Commands\UpdateCustomerCommand;
use TestApi\Domain\Customer\Repository\CustomerRepository;
use TestApi\Transformer\CustomerTransformer;
use TestApi\Transformer\Transformer;

class CustomerController extends AbstractController
{
    /**
     * @var \TestApi\Domain\Customer\Repository\CustomerRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\Customer\Repository\CustomerRepository $repository
     * @param \TestApi\Transformer\Transformer                       $transformer
     */
    public function __construct(CustomerRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $customerId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $customerId): Response
    {
        $customer = $this->repository->get($customerId);

        return $this->response($this->item($customer, CustomerTransformer::class));
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
        $customers = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($customers, CustomerTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $customer = $commandBus->execute(new AddCustomerCommand($request->post()));

        return $this->response($this->item($customer, CustomerTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $customerId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $customerId, Request $request, CommandBus $commandBus): Response
    {
        $customer = $commandBus->execute(new UpdateCustomerCommand($customerId, $request->post()));

        return $this->response($this->item($customer, CustomerTransformer::class));
    }

    /**
     * @param int $customerId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $customerId): Response
    {
        $this->repository->remove($customerId);

        return $this->response();
    }
}
