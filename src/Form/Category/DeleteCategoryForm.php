<?php

namespace App\Form\Category;

use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteCategoryForm extends ABaseForm
{

    use HasValidateOwnership;

    public function __construct(
        private readonly CategoryRepository $categoryRepository
    )
    {
    }

    public function constraints(): array
    {
        return [
            'route' => [
                'id' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ],
            ],
        ];
    }

    public function execute(Request $request)
    {
        $categoryId = self::getParams($request)['route']['id'];
        $category = $this->categoryRepository->find($categoryId);

        if(!$category) {
            throw new BadRequestHttpException("Category {$categoryId} Not Found");
        }

        $shop = $category->getShop();
        $this->ValidateOwnership($shop, $this->getUser()->getId());

        $this->categoryRepository->remove($category, true);
    }
}