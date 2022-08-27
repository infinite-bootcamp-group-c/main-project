<?php

namespace App\Controller;

use App\Form\Product\CreateProductForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('', name: 'app_product_new', methods: ['POST'])]
    #[ParamConverter('validationForm', class: CreateProductForm::class)]
    public function new(?string $validationForm)
    {
        return $this->json($validationForm);
    }
}
