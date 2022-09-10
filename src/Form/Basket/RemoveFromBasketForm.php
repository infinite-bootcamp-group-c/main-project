<?php

namespace App\Form\Basket;

use App\Lib\Form\ABaseForm;
use App\Repository\OrderItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class RemoveFromBasketForm extends ABaseForm
{

    public function __construct(
        private readonly OrderItemRepository $orderItemRepository
    )
    {
    }

    public function constraints(): array
    {
        return [
            "body" => [
                "order_item_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('integer')
                ]
            ]
        ];
    }

    public function execute(Request $request)
    {
        $form = self::getParams($request);
        $orderItemId = $form["body"]["order_item_id"];

        $this->orderItemRepository->removeById($orderItemId, flush: true);

    }

}