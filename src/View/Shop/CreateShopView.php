<?php

namespace App\View\Shop;

use App\Entity\Shop;
use App\Lib\View\ABaseView;

class CreateShopView extends ABaseView
{
    public function execute(Shop $shop): array
    {
        return [
            'id' => $shop->getId(),
            'name' => $shop->getName(),
            'description' => $shop->getDescription(),
            'created_at' => $shop->getCreatedAt(),
        ];
    }
}