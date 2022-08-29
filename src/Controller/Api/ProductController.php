<?php

namespace App\Controller\Api;

use App\Form\Product\Create\ICreateProductForm;
use App\Form\Product\Delete\IDeleteProductForm;
use App\Form\Product\Get\IGetProductForm;
use App\Form\Product\GetList\IGetProductListForm;
use App\Form\Product\Update\IUpdateProductForm;
use App\Lib\Controller\BaseController;
use App\View\Product\Create\ICreateProductView;
use App\View\Product\Delete\IDeleteProductView;
use App\View\Product\Get\IGetProductView;
use App\View\Product\GetList\IGetProductListView;
use App\View\Product\Update\IUpdateProductView;
use OpenApi\Attributes as OA;
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
        Request         $request,
        IGetProductForm $getProductForm,
        IGetProductView $getProductView
    ): JsonResponse
    {
        return $getProductForm->makeResponse($request, $getProductView);
    }

    #[Route('/', name: 'get_product_list', methods: ['GET'])]
    public function getList(
        Request             $request,
        IGetProductListForm $getProductListForm,
        IGetProductListView $getProductListView
    ): JsonResponse
    {
        return $getProductListForm->makeResponse($request, $getProductListView);
    }

    #[Route('/', name: 'create_product', methods: ['POST'])]
    #[RequestBody(content: new OA\JsonContent())]
    public function new(
        Request            $request,
        ICreateProductForm $createProductForm,
        ICreateProductView $createProductView
    ): JsonResponse
    {
        return $createProductForm->makeResponse($request, $createProductView);
    }

    #[Route('/{id}', name: 'update_products', methods: ['PATCH'])]
    #[OA\RequestBody(content: new OA\JsonContent())]
    public function update(
        Request            $request,
        IUpdateProductForm $updateProductForm,
        IUpdateProductView $updateProductView
    ): JsonResponse
    {
        return $updateProductForm->makeResponse($request, $updateProductView);
    }

    #[Route('/{id}', name: 'delete_product', methods: ['DELETE'])]
    public function delete(
        Request            $request,
        IDeleteProductForm $deleteProductForm,
        IDeleteProductView $deleteProductView
    ): JsonResponse
    {
        return $deleteProductForm->makeResponse($request, $deleteProductView);
    }

}
