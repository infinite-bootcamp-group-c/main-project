<?php

namespace App\View\Shop;

use App\Entity\Shop;
use App\Lib\View\ABaseView;
use Symfony\Component\HttpFoundation\Response;

class GetShopView extends ABaseView
{
    protected int $HTTPStatusCode = Response::HTTP_OK;

    public function execute(Shop $shop): array
    {
        return [
            'id' => $shop->getId(),
            'name' => $shop->getName(),
            'vendorPhoneNumber' => $shop->getUser()->getPhoneNumber(),
            'logo' => $shop->getLogo(),
            'description' => $shop->getDescription(),
            'instagram_username' => $shop->getIgUsername(),
            'addresses' => $shop->getAddresses(),
            'created_at' => $shop->getCreatedAt(),
            'updated_at' => $shop->getUpdatedAt(),
        ];
    }
}