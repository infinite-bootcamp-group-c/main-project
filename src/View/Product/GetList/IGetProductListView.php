<?php

namespace App\View\Product\GetList;

use App\Lib\View\IBaseView;

interface IGetProductListView extends IBaseView
{
    public function getData(array $form): array;
}