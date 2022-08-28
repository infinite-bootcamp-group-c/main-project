<?php

namespace App\Controller;

use App\Lib\Controller\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class MainController extends BaseController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function home(Request $request): RedirectResponse
    {
        return $this->redirectToRoute('app.swagger_ui');
    }

}
