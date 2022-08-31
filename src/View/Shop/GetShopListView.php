<?php

namespace App\View\Shop;

use App\Entity\Shop;
use App\Lib\View\ABaseView;

class GetShopListView extends ABaseView
{
    public function execute(array $products): array
    {
        return array_map(function (Shop $shop) {
            return [
                'id' => $shop->getId(),
                'name' => $shop->getName(),
                'logo' => $shop->getLogo(),
                'description' => $shop->getDescription(),
                'instagram_username' => $shop->getIgUsername(),
                'addresses' => $shop->getAddresses(),
                'created_at' => $shop->getCreatedAt(),
                'updated_at' => $shop->getUpdatedAt(),
            ];
        }, $products);
    }
}