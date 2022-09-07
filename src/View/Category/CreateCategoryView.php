<?php

namespace App\View\Category;

use App\Entity\Category;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class CreateCategoryView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_CREATED;

    public function execute(Category $category): array
    {
        return [
            'id' => $category->getId(),
            'title' => $category->getTitle(),
        ];
    }
}