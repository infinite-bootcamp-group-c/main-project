<?php

namespace App\View\Product;

use App\Lib\View\AListView;
use App\Repository\ProductRepository;


class DeleteProductView extends AListView implements IDeleteProductView
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function getData(array $form): void
    {
        $this->productRepository->removeById($form['route']['id']);
    }

    public function execute(array $params)
    {
        $this->getData($params);
    }
}