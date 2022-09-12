<?php

namespace App\Controller\Api;

use App\Form\Category\CreateCategoryForm;
use App\Form\Category\DeleteCategoryForm;
use App\Form\Category\GetCategoryForm;
use App\Form\Category\GetCategoryListForm;
use App\Form\Category\UpdateCategoryForm;
use App\View\Category\CreateCategoryView;
use App\View\Category\GetCategoryListView;
use App\View\Category\GetCategoryView;
use App\View\Category\UpdateCategoryView;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories')]
#[Tag(name: 'Category', description: 'Category operations')]
class CategoryController extends AbstractController
{

    #[Route('', name: 'get_category_list', methods: ['GET'])]
    #[
        Parameter(name: 'page', in: 'query', required: false, example: 1),
        Parameter(name: 'limit', in: 'query', required: false, example: 10),
        Parameter(name: 'sort', in: 'query', required: false, schema: new Schema(type: 'string', enum: ['ASC', 'DESC']), example: 'ASC'),
        Parameter(name: 'sort_by', in: 'query', required: false, schema: new Schema(type: 'string', enum: ['id', 'createdAt', 'updatedAt']), example: 'createdAt'),
    ]
    public function getList(
        Request             $request,
        GetCategoryListForm $getCategoryListForm,
        GetCategoryListView $getCategoryListView
    ): JsonResponse
    {
        return $getCategoryListForm->makeResponse($request, $getCategoryListView);
    }

    #[Route('/{id}', name: 'get_category', methods: ['GET'])]
    public function get(
        Request         $request,
        GetCategoryForm $getCategoryForm,
        GetCategoryView $getCategoryView
    ): JsonResponse
    {
        return $getCategoryForm->makeResponse($request, $getCategoryView);
    }

    #[Route('/', name: 'create_category', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function new(
        Request            $request,
        CreateCategoryForm $createCategoryForm,
        CreateCategoryView $createCategoryView
    ): JsonResponse
    {
        return $createCategoryForm->makeResponse($request, $createCategoryView);
    }

    #[Route('/{id}', name: 'update_category', methods: ['PATCH'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function update(
        Request            $request,
        UpdateCategoryForm $updateCategoryForm,
        UpdateCategoryView $updateCategoryView
    ): JsonResponse
    {
        return $updateCategoryForm->makeResponse($request, $updateCategoryView);
    }

    #[Route('/{id}', name: 'delete_category', methods: ['DELETE'])]
    public function delete(
        Request            $request,
        DeleteCategoryForm $deleteCategoryForm
    ): JsonResponse
    {
        return $deleteCategoryForm->makeResponse($request);
    }
}
