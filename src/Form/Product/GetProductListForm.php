<?php

namespace App\Form\Product;

use App\Lib\Form\ABaseForm;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class GetProductListForm extends ABaseForm
{

    public function __construct(
        private readonly ProductRepository $productRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): array
    {
        return $this->productRepository->findAll();
    }
}