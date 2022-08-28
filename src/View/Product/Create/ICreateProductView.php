<?php

namespace App\View\Product\Create;

use App\Entity\Product;
use App\Lib\View\IBaseView;

interface ICreateProductView extends IBaseView
{
    public function getData(Product $product): array;
}