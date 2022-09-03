<?php

namespace App\Form\Product;

use App\Repository\CategoryRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait TCategoryAndShopValidate
{
    #[Required]
    public ShopRepository $shopRepository;
    #[Required]
    public CategoryRepository $categoryRepository;
    #[Required]
    public TokenStorageInterface $tokenStorage;

    public function validation(array $form): array
    {
        $shopId = $form['body']['shop_id'];
        $categoryId = $form['body']['category_id'];

        $shop = $this->shopRepository->find($shopId);
        $category = $this->categoryRepository->find($categoryId);

        if (!$shop) {
            throw new BadRequestException("Shop ${shopId} not found");
        }

        if($shop->getUser()->getId() !== $this->tokenStorage->getToken()->getUser()->getId()){
            throw new BadRequestException('You are not allowed to create product in this shop');
        }

        if (!$category) {
            throw new BadRequestException("Category ${categoryId} not found");
        }

        if($category->getShop()->getId() !== $shop->getId()){
            throw new BadRequestException('The category is not belong to this shop');
        }

        return [
            'shop' => $shop,
            'category' => $category,
        ];
    }
}