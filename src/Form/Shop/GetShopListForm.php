<?php

namespace App\Form\Shop;

use App\Lib\Form\ABaseForm;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetShopListForm extends ABaseForm
{
    public function __construct(
        private readonly ShopRepository $shopRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): array
    {
        return $this->shopRepository->findAll();
    }
}