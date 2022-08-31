<?php

namespace App\Form\Category;

use App\Entity\Category;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCategoryForm extends ABaseForm
{

    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly ShopRepository $shopRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [
            'body' => [
                'shop_id' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('integer'),
                ],
                'title' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'Category name must contain only letters, numbers and underscores'),
                ],
            ],
        ];
    }

    public function execute(Request $request): Category
    {
        $form = self::getParams($request);

        $category = (new Category())
            ->setTitle($form['body']['title'])
            ->setShop(
                $this->shopRepository->find($form['body']['shop_id'])
            );

        $this->categoryRepository->add($category, true);

        return $category;
    }
}