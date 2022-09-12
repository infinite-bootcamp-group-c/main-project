<?php

namespace App\Form\Basket;

use App\Lib\Form\ABaseForm;
use App\Repository\OrderItemRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
            "route" => [
                "order_item_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit')
                ]
            ]
        ];
    }

    public function execute(array $form)
    {
        $orderItemId = $form["body"]["order_item_id"];

        try {
            $this->orderItemRepository->removeById($orderItemId, flush: true);
        } catch (EntityNotFoundException){
            throw new NotFoundHttpException("Order item with this id not found!");
        }
    }

}
