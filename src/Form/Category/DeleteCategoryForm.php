<?php

namespace App\Form\Category;

use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteCategoryForm extends ABaseForm
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

    public function execute(Request $request)
    {
        $categoryId = self::getParams($request)['route']['id'];

        if($this->categoryRepository->find($categoryId)
                ->getShop()
                ->getUser()
                ->getId() !== $this->getUser()->getId()) {
            throw new NotFoundHttpException('you are not allowed to delete this category');
        }

        try {
            $this->categoryRepository->removeById($categoryId);
        } catch (EntityNotFoundException) {
            throw new NotFoundHttpException("Category {$categoryId} Not Found");
        }
    }
}