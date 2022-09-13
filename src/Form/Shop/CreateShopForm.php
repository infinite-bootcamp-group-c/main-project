<?php

namespace App\Form\Shop;

use App\Entity\Shop;
use App\Lib\Form\ABaseForm;
use App\Repository\ShopRepository;
use Symfony\Component\Validator\Constraints as Assert;

class CreateShopForm extends ABaseForm
{

    public function __construct(
        private readonly ShopRepository $shopRepository
    )
    {
    }

    public function constraints(): array
    {
        return [
            'body' => [
                'name' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'The shop name {{ value }} is not valid.'),
                ],
                'ig_username' => [
                    new Assert\Length(['max' => 30]),
                    new Assert\Regex(pattern: '/^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$/',
                        message: 'The instagram username {{ value }} is not valid.'),
                ],
                'logo_url' => [
                    new Assert\Regex('\w'),
                ],
                'description' => [
                    new Assert\Length(['max' => 255]),
                ],
            ],
        ];
    }

    public function execute(array $form): Shop
    {
        $shop = (new Shop())
            ->setName($form["body"]["name"])
            ->setIgUsername($form["body"]["ig_username"] ?? null)
            ->setDescription($form["body"]["description"] ?? null)
            ->setLogo($form["body"]["logo_url"] ?? null)
            ->setUser($this->getUser());

        $this->shopRepository->add($shop, true);

        return $shop;
    }
}
