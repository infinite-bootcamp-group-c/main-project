<?php

namespace App\View\Product\Delete;

use App\Lib\View\ABaseView;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;


class DeleteProductView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_NO_CONTENT;

    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function execute(array $params)
    {

    }

    public function getData(array $form): void
    {
    }
}