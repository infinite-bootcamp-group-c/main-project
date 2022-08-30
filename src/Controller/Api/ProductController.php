<?php

namespace App\Controller\Api;

use App\Form\Product\CreateProductForm;
use App\Form\Product\DeleteProductForm;
use App\Form\Product\GetProductForm;
use App\Form\Product\GetProductListForm;
use App\Form\Product\UpdateProductForm;
use App\Lib\Controller\BaseController;
use App\View\Product\CreateProductView;
use App\View\Product\GetProductListView;
use App\View\Product\GetProductView;
use App\View\Product\UpdateProductView;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products')]
#[Tag(name: 'Product', description: 'Product operations')]
class ProductController extends BaseController
{

    #[Route('/{id}', name: 'get_product', methods: ['GET'])]
    public function get(
        Request        $request,
        GetProductForm $getProductForm,
        GetProductView $getProductView
    ): JsonResponse
    {
        return $getProductForm->makeResponse($request, $getProductView);
    }

    #[Route('/', name: 'get_product_list', methods: ['GET'])]
    public function getList(
        Request             $request,
        GetProductListForm $getProductListForm,
        GetProductListView $getProductListView
    ): JsonResponse
    {
        return $getProductListForm->makeResponse($request, $getProductListView);
    }

    #[Route('/', name: 'create_product', methods: ['POST'])]
    #[RequestBody(content: new JsonContent())]
    public function new(
        Request            $request,
        CreateProductForm $createProductForm,
        CreateProductView $createProductView
    ): JsonResponse
    {
        return $createProductForm->makeResponse($request, $createProductView);
    }

    #[Route('/{id}', name: 'update_products', methods: ['PATCH'])]
    #[RequestBody(content: new JsonContent())]
    public function update(
        Request            $request,
        UpdateProductForm $updateProductForm,
        UpdateProductView $updateProductView
    ): JsonResponse
    {
        return $updateProductForm->makeResponse($request, $updateProductView);
    }

    #[Route('/{id}', name: 'delete_product', methods: ['DELETE'])]
    public function delete(
        Request            $request,
        DeleteProductForm $deleteProductForm,
    ): JsonResponse
    {
        return $deleteProductForm->makeResponse($request);
    }

}
