<?php

namespace App\Form\Category;

use App\Entity\Category;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class GetCategoryForm extends ABaseForm
{

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

    public function execute(array $form): Category
    {
        $categoryId = $form['route']['id'];
        $category = $this->categoryRepository->find($categoryId);

        if (!$category) {
            throw new NotFoundHttpException("Category $categoryId not found");
        }

        return $category;
    }
}
