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
}