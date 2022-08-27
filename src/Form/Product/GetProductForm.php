<?php

namespace App\Form\Product;

use App\Lib\Form\ABaseForm;
use App\View\Product\IGetProductView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetProductForm extends ABaseForm implements IGetProductForm
{

    public function __construct(private readonly IGetProductView $getProductView, private readonly ValidatorInterface $validator)
    {
        parent::__construct($this->validator);
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

    public function execute(Request $request): array
    {
        return $this->getProductView->execute(self::getParams($request));
    }
}