<?php

namespace App\Lib\Repository\Pagination;

use Symfony\Component\Validator\Constraints as Assert;

trait HasFormPaginator
{
    public function paginatorGetQueryParam(): array
    {
        return [
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
        ];
    }

    public function paginatorPaginate($repository, $query)
    {
        return $repository->paginate(
            page: $query['page'] ?? 1,
            limit: $query['limit'] ?? 10,
            sort: $query['sort'] ?? 'ASC',
            sortBy: $query['sort_by'] ?? 'createdAt',
        );
    }
}