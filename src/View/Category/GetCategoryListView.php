<?php

namespace App\View\Category;

use App\Entity\Category;
use App\Lib\View\ABaseView;

class GetCategoryListView extends ABaseView
{

    public function execute(array $categories): array
    {
        return array_map(function (Category $category) {
            return [
                'id' => $category->getId(),
                'title' => $category->getTitle(),
                'created_at' => $category->getCreatedAt(),
                'updated_at' => $category->getUpdatedAt(),
            ];
        }, $categories);
    }
}