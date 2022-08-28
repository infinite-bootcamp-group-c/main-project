<?php

namespace App\View\Product\Delete;

use App\Lib\View\ABaseView;
use App\Repository\ProductRepository;


class DeleteProductView extends ABaseView implements IDeleteProductView
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function execute(array $params)
    {
        $this->getData($params);
    }

    public function getData(array $form): void
    {
        $this->productRepository->removeById($form['route']['id']);
    }
}