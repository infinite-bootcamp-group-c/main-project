<?php

namespace App\Form\Shop;

use App\Lib\Form\ABaseForm;
use App\Lib\Repository\Pagination\HasFormPaginator;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;

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

    public function execute(Request $request): array
    {
        return $this->paginatorPaginate(
            $this->shopRepository, self::getQueryParams($request)
        );
    }
}
