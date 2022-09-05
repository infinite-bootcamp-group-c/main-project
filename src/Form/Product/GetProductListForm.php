<?php

namespace App\Form\Product;

use App\Lib\Form\ABaseForm;
use App\Lib\Repository\Pagination\HasFormPaginator;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class GetProductListForm extends ABaseForm
{
    use HasFormPaginator;

    public function __construct(
        private readonly ProductRepository $productRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [
            'query' => [
                ...$this->paginatorGetQueryParam(),
            ],
        ];
    }

    public function execute(Request $request): array
    {
        return $this->paginatorPaginate(
            $this->productRepository, self::getQueryParams($request)
        );
    }
}