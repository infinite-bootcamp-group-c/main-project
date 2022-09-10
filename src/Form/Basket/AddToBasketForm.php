<?php

namespace App\Form\Basket;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Shop;
use App\Entity\Order;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use App\Lib\Form\ABaseForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddToBasketForm extends ABaseForm
{

    public function __construct(
        private readonly ProductRepository   $productRepository,
        private readonly OrderRepository     $orderRepository,
        private readonly OrderItemRepository $orderItemRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [
            "body" => [
                "product_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                "quantity" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ]
            ]
        ];
    }

    public function execute(Request $request): array
    // TODO if the order is not open can not do it
    // TODO if quantity of product is less that now
    {
        $form = self::getParams($request);

        $productId = $form["body"]["product_id"];
        $quantity = $form["body"]["quantity"];

        $product = $this->productRepository->find($productId);
        if (!$product) {
            throw new NotFoundHttpException("Product with this id not found");
        }

        $category = $product->getCategory();
        $shop = $category->getShop();
        $shopId = $shop->getId();
        $user = $this->getUser();
        $userId = $user->getId();

        //check if any order had exist with this product and shop before
        $order = $this->orderRepository->findOneBy(["shop" => $shopId, "user" => $userId, "status" => "open"]);
        if (is_null($order)) {
            $order = $this->orderRepository->createOrder($user, $shop);
            $this->orderRepository->add($order, flush: true);
        }

        $existing_item = $this->orderItemRepository->findOneBy(["order" => $order->getId(), "product" => $productId]);
        if (!is_null($existing_item)) {
            $existing_item->setQuantity($quantity);
            $this->orderItemRepository->flush();
        } else {
            $newItem = $this->orderItemRepository->createOrderItem($product, $quantity, $order);
            $this->orderItemRepository->add($newItem, true);
        }

        $item = !is_null($existing_item) ? $existing_item : $newItem;
        return [
            "order" => $order,
            "orderItem" => $item
        ];


    }


}