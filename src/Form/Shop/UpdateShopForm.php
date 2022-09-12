<?php

namespace App\Form\Shop;

use App\Entity\Shop;
use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateShopForm extends ABaseForm
{
    use HasValidateOwnership;

    public function __construct(
        private readonly ShopRepository $shopRepository
    )
    {
    }

    public function constraints(): array
    {
        return [
            'route' => [
                'id' => [
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                ],
            ],
            'body' => [
                'name' => [
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'The shop name {{ value }} is not valid.'),
                ],
                'ig_username' => [
                    new Assert\Length(min: 3, max: 30),
                    new Assert\Regex(pattern: '/^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$/'
                        , message: 'The instagram username {{ value }} is not valid.'),
                ],
                'logo_url' => [
                    new Assert\Regex(pattern: '/^\w+\.png/',
                        message: "The logo url {{ value }} is not valid."),
                ],
                'description' => [
                    new Assert\Length(max: 255)
                ],
            ],
        ];
    }

    public function execute(array $form): Shop
    {
        $shopId = $form['route']['id'];
        $shop = $this->shopRepository->find($shopId);

        if (!$shop) {
            throw new BadRequestException("Shop ${shopId} not found");
        }

        $this->validateOwnership($shop, $this->getUser()->getId());

        if (isset($form['body']["name"]))
            $shop->setName($form['body']['name']);
        if (isset($form['body']['description']))
            $shop->setDescription($form['body']['description']);
        if (isset($form['body']['logo_url']))
            $shop->setLogo($form['body']['logo_url']);
        if (isset($form['body']['ig_username']))
            $shop->setIgUsername($form['body']['ig_username']);

        $this->shopRepository->flush();

        return $shop;
    }
}
