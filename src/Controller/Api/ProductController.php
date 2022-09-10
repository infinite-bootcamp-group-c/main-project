<?php

namespace App\Controller\Api;

use App\Form\Product\CreateProductForm;
use App\Form\Product\DeleteProductForm;
use App\Form\Product\GetProductForm;
use App\Form\Product\GetProductListForm;
use App\Form\Product\SearchProductListForm;
use App\Form\Product\UpdateProductForm;
use App\Lib\Controller\BaseController;
use App\View\Product\CreateProductView;
use App\View\Product\GetProductListView;
use App\View\Product\GetProductView;
use App\View\Product\SearchProductListView;
use App\View\Product\UpdateProductView;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Schema;
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
    #[
        Parameter(name: 'page', in: 'query', required: false, example: 1),
        Parameter(name: 'limit', in: 'query', required: false, example: 10),
        Parameter(name: 'sort', in: 'query', required: false, schema: new Schema(type: 'string', enum: ['ASC', 'DESC']), example: 'ASC'),
        Parameter(name: 'sort_by', in: 'query', required: false, schema: new Schema(type: 'string', enum: ['id', 'createdAt', 'updatedAt']), example: 'createdAt'),
    ]
    public function getList(
        Request            $request,
        GetProductListForm $getProductListForm,
        GetProductListView $getProductListView
    ): JsonResponse
    {
        return $getProductListForm->makeResponse($request, $getProductListView);
    }

    #[Route('/', name: 'create_product', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function new(
        Request           $request,
        CreateProductForm $createProductForm,
        CreateProductView $createProductView
    ): JsonResponse
    {
        return $createProductForm->makeResponse($request, $createProductView);
    }

    #[Route('/{id}', name: 'update_products', methods: ['PATCH'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function update(
        Request           $request,
        UpdateProductForm $updateProductForm,
        UpdateProductView $updateProductView
    ): JsonResponse
    {
        return $updateProductForm->makeResponse($request, $updateProductView);
    }

    #[Route('/{id}', name: 'delete_product', methods: ['DELETE'])]
    public function delete(
        Request           $request,
        DeleteProductForm $deleteProductForm,
    ): JsonResponse
    {
        return $deleteProductForm->makeResponse($request);
    }


    #[
        Parameter(name: 'query', in: 'query', required: true),
        Parameter(name: 'page', in: 'query', required: false, example: 1),
        Parameter(name: 'limit', in: 'query', required: false, example: 10),
    ]
    #[Route('/search', name: 'search_product', methods: ['GET'])]
    public function search(
        Request               $request,
        SearchProductListForm $searchProductListForm,
        SearchProductListView $searchProductListView,
    ): JsonResponse
    {
        return $searchProductListForm->makeResponse($request, $searchProductListView);
    }

}
