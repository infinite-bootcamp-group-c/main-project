<?php

namespace App\Form\Category;

use App\Lib\Form\ABaseForm;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetCategoryListForm extends ABaseForm
{

    public function __construct(
        private readonly CategoryRepository $categoryRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): array
    {
        return $this->categoryRepository->findAll();
    }
}