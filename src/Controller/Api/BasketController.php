<?php

namespace App\Controller\Api;

use App\Lib\Controller\BaseController;
use OpenApi\Attributes\Tag;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/basket')]
#[Tag(name: 'Basket', description: 'Basket operations')]
class BasketController extends BaseController
{

}