<?php

namespace App\Form\Shop;

use App\Entity\Shop;
use App\Lib\Form\ABaseForm;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateShopForm extends ABaseForm
{
    public function __construct(
        private readonly ShopRepository $shopRepository,
        private readonly UserRepository $userRepository,
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
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'Shop name must contain only letters, numbers and underscores'),
                ],
                'user_id' => [
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'ig_username' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 3, max: 30),
                    new Assert\Regex(pattern: '^[\w](?!.*?\.{2})[\w.]{1,28}[\w]$'
                        , message: 'IG username must contain only letters, numbers and underscores'),
                ],
                'logo_url' => [
                    new Assert\Regex('/^\w+\.png/', "wrong pattern for shop logo image url"),
                ],
                'description' => [
                    new Assert\Length(max:255, maxMessage: "description must be 255 characters at most."),
                ],
            ],
        ];
    }

    public function execute(Request $request): Shop
    {
        $form = self::getParams($request);

        $shopId = $form['route']['id'];
        $shop = $this->shopRepository->find($shopId);

        if (!$shop) {
            throw new BadRequestException("Shop ${shopId} not found");
        }

        if(isset($form['body']['user_id'])) {
            $userId = $form['body']['user_id'];
            $user = $this->userRepository->find($userId);
            if (!$user) {
                throw new BadRequestException("Category ${userId} not found");
            }
            $shop->setUser($user);
        }
        if(isset($form['body']["name"]))
            $shop->setName($form['body']['name']);
        if(isset($form['body']['description']))
            $shop->setDescription($form['body']['description']);
        if(isset($form['body']['logo_url']))
            $shop->setLogo($form['body']['logo_url']);
        if(isset($form['body']['ig_username']))
            $shop->setIgUsername($form['body']['ig_username']);

        $this->shopRepository->flush();

        return $shop;
    }
}