<?php

namespace App\Form\Product;

use App\Entity\Product;
use App\Form\Product\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateProductForm extends ABaseForm
{
    use HasValidateOwnership;

    public function __construct(
        private readonly ProductRepository  $productRepository,
        private readonly ShopRepository     $shopRepository,
        private readonly CategoryRepository $categoryRepository,
    )
    {
    }

    public
    function constraints(): array
    {
        return [
            'route' => [
                'id' => [
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                ],
            ],
            'body' => [
                'category_id' => [
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'shop_id' => [
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'name' => [
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'The product name {{ value }} is not valid.'),
                ],
                'price' => [
                    new Assert\Type('integer'),
                    new Assert\positive(),
                ],
                'quantity' => [
                    new Assert\Type('integer'),
                    new Assert\Positive(),
                ],
                'description' => [
                    new Assert\Length(min: 150, max: 1000),
                    new Assert\Regex(pattern: '/^\w+/',
                        message: 'The product description {{ value }} is not valid.'),
                ],
            ],
        ];
    }

    public function execute(Request $request): Product
    {
        $form = self::getParams($request);

        $productId = $form['route']['id'];
        $product = $this->productRepository->find($productId);

        if (!$product)
            throw new BadRequestHttpException("Product ${productId} not found");

        $productCategory = $product->getCategory();
        $shop = $productCategory->getShop();

        $this->validateOwnership($shop, $this->getUser()->getId());

        if (isset($form['body']["name"]))
            $product->setName($form['body']['name']);

        if (isset($form['body']['price']))
            $product->setPrice($form['body']['price']);

        if (isset($form['body']['category_id'])) {
            $categoryId = $form['body']['category_id'];
            $category = $this->categoryRepository->find($categoryId);

            if (!$category)
                throw new BadRequestHttpException("Category ${categoryId} not found");

            $this->validateOwnership($this->shopRepository->find($category->getShop()->getId()),
                $this->getUser()->getId());

            $product->setCategory($category);
        }

        if(isset($form['body']['shop_id'])){
            $shopId = $form['body']['shop_id'];
            $shop = $this->shopRepository->find($shopId);

            if(!$shop)
                throw new BadRequestHttpException("Shop ${shopId} not found");

            $this->validateOwnership($shop, $this->getUser()->getId());

            $productCategory->setShop($shop);
        }

        if (isset($form['body']['description']))
            $product->setDescription($form['body']['description']);

        if (isset($form['body']['quantity']))
            $product->setQuantity($form['body']['quantity']);

        $this->productRepository->flush();

        return $product;
    }
}