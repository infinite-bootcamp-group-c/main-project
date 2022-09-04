<?php

namespace App\Form\Product\Traits;

use App\Entity\Category;
use App\Entity\Shop;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait HasValidateCategoryOwnership
{
    public function validateCategoryOwnership(Shop $shop, Category $category): void
    {
        if ($category->getShop()->getId() !== $shop->getId()) {
            throw new BadRequestHttpException('The category is not belong to this shop');
        }
    }
}