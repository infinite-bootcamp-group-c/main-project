<?php

namespace App\Lib\View;

interface IBaseView
{
    public function getHTTPStatusCode(): int;
}