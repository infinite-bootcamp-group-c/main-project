<?php

namespace App\View\Product\Delete;

use App\Lib\View\ABaseView;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;


class DeleteProductView extends ABaseView implements IDeleteProductView
{
    protected int $HTTPStatusCode = Response::HTTP_NO_CONTENT;

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