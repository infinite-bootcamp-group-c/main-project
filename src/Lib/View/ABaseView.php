<?php

namespace App\Lib\View;

use Symfony\Component\HttpFoundation\Response;

abstract class ABaseView implements IBaseView
{
    protected int $HTTPStatusCode = Response::HTTP_OK;

    /**
     * @return int
     */
    public function getHTTPStatusCode(): int
    {
        return $this->HTTPStatusCode;
    }

    public function renderPaginated(array $items, $callback): array
    {
        return [
            ...$items,
            'items' => array_map($callback, $items['items']),
        ];
    }

}