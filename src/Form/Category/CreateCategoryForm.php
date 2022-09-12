<?php

namespace App\Form\Category;

use App\Entity\Category;
use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCategoryForm extends ABaseForm
{
    use HasValidateOwnership;

    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly ShopRepository     $shopRepository,
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
                        , message: 'The category name {{ value }} is not valid.'),
                ],
            ],
        ];
    }

    public function execute(array $form): Category
    {
        $shopId = $form['body']['shop_id'];
        $shop = $this->shopRepository->find($shopId);

        if (!$shop) {
            throw new BadRequestHttpException("Shop {$shopId} not found");
        }

        $this->validateOwnership($shop, $this->getUser()->getId());

        $category = (new Category())
            ->setTitle($form['body']['title'])
            ->setShop($shop);

        $this->categoryRepository->add($category, true);

        return $category;
    }
}
