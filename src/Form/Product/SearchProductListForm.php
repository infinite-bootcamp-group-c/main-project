<?php

namespace App\Form\Product;

use Algolia\AlgoliaSearch\Exceptions\AlgoliaException;
use Algolia\SearchBundle\SearchService;
use App\Entity\Product;
use App\Lib\Form\ABaseForm;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class SearchProductListForm extends ABaseForm
{

    public function __construct(
        private readonly SearchService   $searchService,
        private readonly ManagerRegistry $managerRegistry
    )
    {
    }

    public function constraints(): array
    {
        return [
            'query' => [
                'page' => [
                    new Assert\PositiveOrZero(),
                ],
                'limit' => [
                    new Assert\PositiveOrZero(),
                ],
                'query' => [
                    new Assert\NotBlank(),
                ],
            ],
        ];
    }

    public function execute(array $form): array
    {
        $query = $form["query"];
        $limit = $query['limit'] ?? 10;
        $page = $query['page'] ?? 1;

        $em = $this->managerRegistry->getManagerForClass(Product::class);
        try {
            $products = $this->searchService->search(
                $em,
                Product::class,
                $query['query'],
                [
                    'page' => $page - 1,
                    'hitsPerPage' => $limit,
                ]);
            $totalItems = $this->searchService->count(Product::class, $query['query']);
        } catch (AlgoliaException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return [
            'items' => $products,
            'totalItems' => $totalItems,
            'itemsPerPage' => $limit,
            'totalPages' => ceil($totalItems / $limit),
            'currentPage' => $page,
        ];
    }
}
