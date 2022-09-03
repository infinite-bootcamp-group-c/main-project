<?php

namespace App\Lib\Repository;

trait HasPaginator
{
    public function paginate(int $page = 1, int $limit = 10, string $sort = 'ASC', string $sortBy = 'createdAt', array $criteria = []): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.' . $sortBy, $sort)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        foreach ($criteria as $key => $value) {
            $queryBuilder->andWhere('p.' . $key . ' = :' . $key);
            $queryBuilder->setParameter($key, $value);
        }

        return [
            'items' => $queryBuilder->getQuery()->getResult(),
            'totalItems' => $this->count([]),
            'itemsPerPage' => $limit,
            'totalPages' => ceil($this->count([]) / $limit),
            'currentPage' => $page,
        ];
    }
}