<?php

namespace App\Form\Category;

use App\Lib\Form\ABaseForm;
use App\Lib\Repository\Pagination\HasFormPaginator;
use App\Repository\CategoryRepository;

class GetCategoryListForm extends ABaseForm
{

    use HasFormPaginator;

    public function __construct(
        private readonly CategoryRepository $categoryRepository
    )
    {
    }

    public function constraints(): array
    {
        return [
            'query' => [
                ...$this->paginatorGetQueryParam(),
            ]
        ];
    }

    public function execute(array $form): array
    {
        return $this->paginatorPaginate(
            $this->categoryRepository, $form
        );
    }
}
