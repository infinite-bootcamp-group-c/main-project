<?php

namespace App\Form\Product;

use App\Lib\Form\ABaseForm;
use App\View\Product\IGetProductListView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetProductListForm extends ABaseForm implements IGetProductListForm
{

    public function __construct(
        private readonly IGetProductListView   $getProductListView,
        private readonly ValidatorInterface    $validator,
        private readonly TokenStorageInterface $tokenStorage,
    )
    {
        parent::__construct($this->validator, $this->tokenStorage);
    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): array
    {
        return $this->getProductListView->execute(self::getParams($request));
    }
}