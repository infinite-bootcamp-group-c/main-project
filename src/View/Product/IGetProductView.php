<?php

namespace App\View\Product;

use App\Entity\Product;
use App\Lib\View\IBaseView;

interface IGetProductView extends IBaseView
{
    public function getData(array $form): Product;
}