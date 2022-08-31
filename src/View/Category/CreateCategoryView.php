<?php

namespace App\View\Category;

use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class CreateCategoryView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(array $categories): array
    {
        return array_map(function ($category) {
            return [
                'id' => $category->getId(),
                'title' => $category->getTitle(),
                'created_at' => $category->getCreatedAt(),
                'updated_at' => $category->getUpdatedAt(),
            ];
        }, $categories);
    }
}