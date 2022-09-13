<?php

namespace App\Form\Shop;

use App\Lib\Form\ABaseForm;
use App\Lib\Repository\Pagination\HasFormPaginator;
use App\Repository\ShopRepository;

class GetShopListForm extends ABaseForm
{
    use HasFormPaginator;

    public function __construct(
        private readonly ShopRepository $shopRepository,
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

    public function execute(array $form): array
    {
        return $this->paginatorPaginate(
            $this->shopRepository, $form["query"]
        );
    }
}
