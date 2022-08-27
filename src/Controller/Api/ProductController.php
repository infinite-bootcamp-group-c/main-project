<?php

namespace App\Controller\Api;

use App\Form\Product\ICreateProductForm;
use App\Form\Product\IDeleteProductForm;
use App\Form\Product\IGetProductForm;
use App\Form\Product\IGetProductListForm;
use App\Form\Product\IUpdateProductForm;
use App\Lib\Controller\BaseController;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products')]
#[Tag(name: 'Product', description: 'Product operations')]
class ProductController extends BaseController
{
    #[Route('/', name: 'create_product', methods: ['POST'])]

    public function new(Request $request, ICreateProductForm $createProductForm): JsonResponse
    {
        return $this->makeResponse($createProductForm, $request);
    }

    #[Route('/{id}', name: 'delete_product', methods: ['DELETE'])]
    public function delete(Request $request, IDeleteProductForm $deleteProductForm): JsonResponse
    {
        return $this->makeResponse($deleteProductForm, $request);
    }

    #[Route('/{id}', name: 'get_product', methods: ['GET'])]
    public function get(Request $request, IGetProductForm $getProductForm): JsonResponse
    {
        return $this->makeResponse($getProductForm, $request);
    }

    #[Route('/', name: 'get_product_list', methods: ['GET'])]
    public function getList(Request $request, IGetProductListForm $getProductListForm): JsonResponse
    {
        return $this->makeResponse($getProductListForm, $request);
    }

    #[Route('/{id}', name: 'update_products', methods: ['PATCH'])]
    public function update(Request $request, IUpdateProductForm $updateProductForm): JsonResponse
    {
        return $this->makeResponse($updateProductForm, $request);
    }

}
