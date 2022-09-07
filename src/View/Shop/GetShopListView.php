<?php

namespace App\View\Shop;

use App\Entity\Shop;
use App\Lib\View\ABaseView;

class GetShopListView extends ABaseView
{
    public function execute(array $products): array
    {
        return $this->renderPaginated($products, function (Shop $shop) {
            return [
                'id' => $shop->getId(),
                'name' => $shop->getName(),
                'createdAt' => $shop->getCreatedAt(),
                'updatedAt' => $shop->getUpdatedAt(),
            ];
        });
    }
}