<?php

namespace App\Form\Product;

use App\Lib\Form\ABaseForm;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class GetProductListForm extends ABaseForm
{

    public function __construct(
        private readonly ProductRepository $productRepository,
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
                'sort' => [
                    new Assert\Choice(choices: ['ASC', 'DESC']),
                ],
                'sort_by' => [
                    new Assert\Choice(choices: ['id', 'createdAt', 'updatedAt']),
                ],
            ],
        ];
    }

    public function execute(Request $request): array
    {
        $query = self::getQueryParams($request);
        return $this->productRepository->paginate(
            page: $query['page'] ?? 1,
            limit: $query['limit'] ?? 10,
            sort: $query['sort'] ?? 'ASC',
            sortBy: $query['sort_by'] ?? 'createdAt',
        );
    }
}