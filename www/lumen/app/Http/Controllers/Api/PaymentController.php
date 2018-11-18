<?php declare(strict_types=1);

namespace TestApi\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use TestApi\Command\Bus\CommandBus;
use TestApi\Domain\Payment\Commands\AddPaymentCommand;
use TestApi\Domain\Payment\Commands\UpdatePaymentCommand;
use TestApi\Domain\Payment\Repository\PaymentRepository;
use TestApi\Transformer\PaymentTransformer;
use TestApi\Transformer\Transformer;

class PaymentController extends AbstractController
{
    /**
     * @var \TestApi\Domain\Payment\Repository\PaymentRepository
     */
    private $repository;

    /**
     * @param \TestApi\Domain\Payment\Repository\PaymentRepository $repository
     * @param \TestApi\Transformer\Transformer                     $transformer
     */
    public function __construct(PaymentRepository $repository, Transformer $transformer)
    {
        $this->repository = $repository;

        parent::__construct($transformer);
    }

    /**
     * @param int $paymentId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $paymentId): Response
    {
        $payment = $this->repository->get($paymentId);

        return $this->response($this->item($payment, PaymentTransformer::class));
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
        $payments = new LengthAwarePaginator($items, $total, $pageSize, $page);

        return $this->response($this->collection($payments, PaymentTransformer::class));
    }

    /**
     * @param \Illuminate\Http\Request       $request
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CommandBus $commandBus): Response
    {
        $payment = $commandBus->execute(new AddPaymentCommand($request->post()));

        return $this->response($this->item($payment, PaymentTransformer::class), Response::HTTP_CREATED);
    }

    /**
     * @param int                            $paymentId
     * @param \Illuminate\Http\Request       $request
     *
     * @param \TestApi\Command\Bus\CommandBus $commandBus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(int $paymentId, Request $request, CommandBus $commandBus): Response
    {
        $payment = $commandBus->execute(new UpdatePaymentCommand($paymentId, $request->post()));

        return $this->response($this->item($payment, PaymentTransformer::class));
    }

    /**
     * @param int $paymentId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $paymentId): Response
    {
        $this->repository->remove($paymentId);

        return $this->response();
    }
}
