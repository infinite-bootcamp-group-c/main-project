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

class AddToBasketForm extends ABaseForm
{

    public function __construct(
        private readonly ProductRepository   $productRepository,
        private readonly OrderRepository     $orderRepository,
        private readonly OrderItemRepository $orderItemRepository,
        private readonly ShopRepository      $shopRepository,
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

        if (!$order) {
            $newOrder = $this->orderRepository->createOrder($user, $shop);
            $this->orderRepository->add($newOrder, flush:true);
        }

        $existing_item = $this->orderItemRepository->findOneBy(["order" => $order->getId(), "product" => $productId]);
        return [];

    }
}