<?php

namespace App\Form\Basket;

use App\Entity\Enums\OrderStatus;
use App\Entity\Order;
use App\Lib\Form\ABaseForm;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class GetCurrentBasketForm extends ABaseForm
{

    public function __construct(
        private readonly OrderRepository $orderRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [
            "route" => [
                "shop_id" => [
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                ]
            ]
        ];
    }

    public function execute(array $form): Order
    {
        $user = $this->getUser();
        $shopId = $form["route"]["shop_id"];
        $currentOrder = $this->orderRepository->findOneBy(
            [
                "status" => OrderStatus::OPEN,
                "user" => $user->getId(),
                "shop" => $shopId
            ]
        );

        if (is_null($currentOrder)) {
            throw new NotFoundHttpException("you have no current basket on this shop. try adding some product");
        }
        //TODO calculate total price
        return $currentOrder;
    }
}
