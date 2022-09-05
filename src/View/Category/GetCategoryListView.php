<?php

namespace App\View\Category;

use App\Entity\Category;
use App\Lib\View\ABaseView;

class GetCategoryListView extends ABaseView
{

    public function execute(array $categories): array
    {
        return $this->renderPaginated($categories, function (Category $category) {
            return [
                'id' => $category->getId(),
                'title' => $category->getTitle(),
                'shop' => $category->getShop()->getName(),
                'vendorPhoneNumbers' => $category->getShop()
                    ->getUser()
                    ->getPhoneNumber(),
                'createdAt' => $category->getCreatedAt(),
                'updatedAt' => $category->getUpdatedAt(),
            ];
        });
    }
}