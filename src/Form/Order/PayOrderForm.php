<?php

namespace App\Form\Order;

use App\Lib\Form\ABaseForm;
use App\Repository\OrderRepository;
use Symfony\Component\Validator\Constraints as Assert;

class PayOrderForm extends ABaseForm
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute()
    {

    }
}