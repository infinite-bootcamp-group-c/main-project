<?php

namespace App\View\Product\Delete;

use App\Lib\View\IBaseView;

interface IDeleteProductView extends IBaseView
{
    public function getData(array $form): void;
}