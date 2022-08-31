<?php

namespace App\View\Category;

use App\Entity\Category;
use App\Lib\View\ABaseView;

class UpdateCategoryView extends ABaseView
{

    public function execute(Category $category): array
    {
        return [
            'id' => $category->getId(),
            'title' => $category->getTitle(),
            'created_at' => $category->getCreatedAt(),
            'updated_at' => $category->getUpdatedAt(),
        ];
    }

}