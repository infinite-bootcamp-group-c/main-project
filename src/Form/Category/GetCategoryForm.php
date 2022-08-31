<?php

namespace App\Form\Category;

use App\Entity\Category;
use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetCategoryForm extends ABaseForm
{

    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly CategoryRepository $categoryRepository,
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
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ],
            ],
        ];
    }

    public function execute(Request $request): Category
    {
        $form = self::getParams($request);
        $categoryId = $form['route']['id'];
        $category = $this->categoryRepository->find($categoryId);

        if (!$category) {
            throw new NotFoundHttpException("Category ${categoryId} found");
        }

        return $category;
    }
}