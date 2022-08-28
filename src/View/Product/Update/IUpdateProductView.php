<?php

namespace App\View\Product\Update;

use App\Entity\Product;
use App\Lib\View\IBaseView;

interface IUpdateProductView extends IBaseView
{
    public function getData(Product $product): array;
}