<?php

namespace App\Form\Product;

use Algolia\AlgoliaSearch\Exceptions\AlgoliaException;
use Algolia\SearchBundle\SearchService;
use App\Entity\Product;
use App\Lib\Form\ABaseForm;
use App\Lib\Repository\Pagination\HasFormPaginator;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class SearchProductListForm extends ABaseForm
{
    use HasFormPaginator;

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly SearchService     $searchService,
        private readonly ManagerRegistry   $managerRegistry
    )
    {
    }

    public function constraints(): array
    {
        return [
            'query' => [
                ...$this->paginatorGetQueryParam(),
                'search' => [
                    new Assert\NotBlank(),
                ],
            ],
        ];
    }

    public function execute(Request $request): array
    {
        $query = self::getQueryParams($request);

        $limit = $query['limit'] ?? 10;
        $page =  $query['page'] ?? 1;

        $em = $this->managerRegistry->getManagerForClass(Product::class);
        try {
            $products = $this->searchService->search(
                $em,
                Product::class,
                $query['query'],
                [
                    'page' => $page,
                    'hitsPerPage' => $limit,
                ]);
        } catch (AlgoliaException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        return $products;
    }
}