<?php

namespace App\Form\Shop;

use App\Lib\Form\ABaseForm;
use App\Lib\Repository\Pagination\HasFormPaginator;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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