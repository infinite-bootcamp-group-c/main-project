<?php

namespace App\Form\Category;

use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateCategoryForm extends ABaseForm
{

    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly CategoryRepository $categoryRepository,
        private readonly ShopRepository $shopRepository
    )
    {
        parent::__construct($this->validator, $this->tokenStorage);
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
                'title' => [
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'Category name must contain only letters, numbers and underscores'),
                ],
                'shop_id' => [
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
            ],
        ];
    }

    public function execute(Request $request)
    {
        $form = self::getParams($request);

        $categoryId = $form['route']['id'];
        $category = $this->categoryRepository->find($categoryId);

        if(!$category) {
            throw new BadRequestException("Category ${categoryId} not found");
        }

        if(isset($form['body']['title'])) {
            $category->setTitle($form['body']['title']);
        }

        if(isset($form['body']['shop_id'])) {
            $shopId = $form['body']['shop_id'];
            $shop = $this->shopRepository->find($shopId);

            if(!$shop) {
                throw new BadRequestException("Shop ${shopId} not found");
            }

            $category->setShop($shop);
        }
        $this->categoryRepository->flush();

        return $category;
    }
}