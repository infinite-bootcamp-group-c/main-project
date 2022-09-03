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
        GetAddressForm $getAddressesForm,
        GetAddressView $getAddressesView,
    ): JsonResponse {
        return $getAddressesForm->makeResponse($request, $getAddressesView);
    }

    #[Route('/address/{id}', name: 'get_address_details', methods: ['GET'])]
    public function get_address(
        Request $request,
        GetAddressDetailsForm $getAddressesForm,
        GetAddressDetailsView $getAddressesView,
    ): JsonResponse {
        return $getAddressesForm->makeResponse($request, $getAddressesView);
    }

    #[Route('/address/{id}', name: 'delete_address', methods: ['DELETE'])]
    public function delete_address(
        Request $request,
        DeleteAddressForm $deleteAddressForm,
        DeleteAddressView $deleteAddressView
    ): JsonResponse {
        return $deleteAddressForm->makeResponse($request, $deleteAddressView);
    }

    #[Route('/credits', name: 'new_credit', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function new_credit(
        Request $request,
        NewCreditForm $newCreditForm,
        NewCreditView $newCreditView
    ): JsonResponse {
        return $newCreditForm->makeResponse($request, $newCreditView);
    }

    #[Route('/credits', name: 'get_all_credits', methods: ['GET'])]
    public function get_credits(
        Request $request,
        GetCreditsForm $getCreditsForm,
        GetCreditsView $getCreditsView
    ): JsonResponse {
        return $getCreditsForm->makeResponse($request, $getCreditsView);
    }

    #[Route('/credits', name: 'get_credit', methods: ['GET'])]
    public function get_credit(
        Request $request,
        GetCreditDetailsForm $getCreditDetailsForm,
        GetCreditDetailsView $getCreditDetailsView
    ): JsonResponse {
        return $getCreditDetailsForm->makeResponse($request, $getCreditDetailsView);
    }

    #[Route('/credits', name: 'delete_credit', methods: ['DELETE'])]
    public function delete_credit(
        Request $request,
        DeleteCreditForm $deleteCreditForm,
        DeleteCreditView $deleteCreditView
    ): JsonResponse {
        return $deleteCreditForm->makeResponse($request, $deleteCreditView);
    }

}
