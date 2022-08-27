<?php

namespace App\Form\Product;

use App\Lib\Form\ABaseForm;
use App\View\Product\IGetProductListView;
use App\View\Product\IGetProductView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetProductListForm extends ABaseForm implements IGetProductListForm
{

    public function __construct(private readonly IGetProductListView $getProductListView, private readonly ValidatorInterface $validator)
    {
        parent::__construct($this->validator);
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