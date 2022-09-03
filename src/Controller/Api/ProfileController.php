<?php

namespace App\Controller\Api;

use App\Form\User\GetUserForm;
use App\Form\User\RegisterUserForm;
use App\Lib\Controller\BaseController;
use App\View\User\GetUserView;
use App\View\User\RegisterUserView;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profiles')]
#[Tag(name: 'Profile', description: 'Profile operations')]
class ProfileController extends BaseController
{
    #[Route('/address', name: 'new_address', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function new(
        Request        $request,
        NewAddressForm $newAddressForm,
        NewAddressView $newAddressView
    ): JsonResponse
    {
        return $newAddressForm->makeResponse($request, $newAddressView);
    }

    #[Route('/address', name: 'get_all_address', methods: ['GET'])]
    public function get_all_address(
        Request $request,
        GetAddressesForm $getAddressesForm,
        GetAddressesView $getAddressesView,
    ): JsonResponse {
        return $getAddressesForm->makeResponse($request, $getAddressesView);
    }

    #[Route('/address/{id}', name: 'get_address_details', methods: ['GET'])]
    public function get_address(
        Request $request,
        GetAddressesForm $getAddressesForm,
        GetAddressesView $getAddressesView,
    ): JsonResponse {
        return $getAddressesForm->makeResponse($request, $getAddressesView);
    }

    #[Route('/address/{id}', name: 'delete_address')]
    public function delete_address(
        Request $request,
        DeleteAddressForm $deleteAddressForm,
        DeleteAddressView $deleteAddressView
    ): JsonResponse {
        return $deleteAddressForm->makeResponse($request, $deleteAddressView);
    }

}
