<?php declare(strict_types=1);

namespace TestApi\Domain\Payment\Commands\Handlers;

use TestApi\Domain\Payment\Commands\AddPaymentCommand;
use TestApi\Domain\Payment\Commands\UpdatePaymentCommand;
use TestApi\Domain\Payment\Entity\Mapper\PaymentMapper;
use TestApi\Domain\Payment\Repository\PaymentRepository;
use TestApi\Domain\Payment\Validator\PaymentValidator;
use TestApi\Entity\EntityInterface;

class PaymentHandler
{
    /**
     * @var \TestApi\Domain\Payment\Entity\Mapper\PaymentMapper
     */
    private $paymentMapper;

    /**
     * @var \TestApi\Domain\Payment\Repository\PaymentRepository
     */
    private $paymentRepository;

    /**
     * @var \TestApi\Domain\Payment\Validator\PaymentValidator
     */
    private $validator;

    /**
     * @param \TestApi\Domain\Payment\Entity\Mapper\PaymentMapper  $mapper
     * @param \TestApi\Domain\Payment\Repository\PaymentRepository $repository
     * @param \TestApi\Domain\Payment\Validator\PaymentValidator   $validator
     */
    public function __construct(PaymentMapper $mapper, PaymentRepository $repository, PaymentValidator $validator)
    {
        $this->paymentMapper     = $mapper;
        $this->paymentRepository = $repository;
        $this->validator         = $validator;
    }

    /**
     * @param \TestApi\Domain\Payment\Commands\AddPaymentCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleAddPayment(AddPaymentCommand $command): EntityInterface
    {
        $this->validator->validate($command->getAttributes());
        $this->paymentRepository->add($this->paymentMapper->map($command->getAttributes()));

        $paymentId = $this->paymentRepository->lastInsertedId();
        $payment   = $this->paymentRepository->get($paymentId);

        return $payment;
    }


    /**
     * @param \TestApi\Domain\Payment\Commands\UpdatePaymentCommand $command
     *
     * @return \TestApi\Entity\EntityInterface
     * @throws \TestApi\Exceptions\Validation\ValidationException
     */
    public function handleUpdatePayment(UpdatePaymentCommand $command): EntityInterface
    {
        $attributes = array_merge(['payment_id' => $command->getPaymentId()], $command->getAttributes());
        $this->validator->validate($attributes);

        return $this->paymentRepository->update(
            $command->getPaymentId(),
            $this->paymentMapper->map($command->getAttributes())
        );
    }
}
