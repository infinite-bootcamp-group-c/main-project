<?php

namespace App\Controller\Api;

use App\Form\Profile\DeleteAddressForm;
use App\Form\Profile\DeleteCreditForm;
use App\Form\Profile\GetAddressDetailsForm;
use App\Form\Profile\GetAddressForm;
use App\Form\Profile\GetCreditDetailsForm;
use App\Form\Profile\GetCreditsForm;
use App\Form\Profile\NewAddressForm;
use App\Form\Profile\NewCreditForm;
use App\Lib\Controller\BaseController;
use App\View\Profile\DeleteAddressView;
use App\View\Profile\DeleteCreditView;
use App\View\Profile\GetAddressDetailsView;
use App\View\Profile\GetAddressView;
use App\View\Profile\GetCreditDetailsView;
use App\View\Profile\GetCreditView;
use App\View\Profile\NewAddressView;
use App\View\Profile\NewCreditView;
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
        Request        $request,
        GetAddressForm $getAddressesForm,
        GetAddressView $getAddressesView,
    ): JsonResponse
    {
        return $getAddressesForm->makeResponse($request, $getAddressesView);
    }

    #[Route('/address/{id}', name: 'get_address_details', methods: ['GET'])]
    public function get_address(
        Request               $request,
        GetAddressDetailsForm $getAddressesForm,
        GetAddressDetailsView $getAddressesView,
    ): JsonResponse
    {
        return $getAddressesForm->makeResponse($request, $getAddressesView);
    }

    #[Route('/address/{id}', name: 'delete_address', methods: ['DELETE'])]
    public function delete_address(
        Request           $request,
        DeleteAddressForm $deleteAddressForm,
    ): JsonResponse
    {
        return $deleteAddressForm->makeResponse($request);
    }

    #[Route('/credits', name: 'new_credit', methods: ['POST'])]
    #[RequestBody(content: new JsonContent(default: '{}'))]
    public function new_credit(
        Request       $request,
        NewCreditForm $newCreditForm,
        NewCreditView $newCreditView
    ): JsonResponse
    {
        return $newCreditForm->makeResponse($request, $newCreditView);
    }

    #[Route('/credits', name: 'get_all_credits', methods: ['GET'])]
    public function get_credits(
        Request        $request,
        GetCreditsForm $getCreditsForm,
        GetCreditView  $getCreditsView
    ): JsonResponse
    {
        return $getCreditsForm->makeResponse($request, $getCreditsView);
    }

    #[Route('/credits/{id}', name: 'get_credit', methods: ['GET'])]
    public function get_credit(
        Request              $request,
        GetCreditDetailsForm $getCreditDetailsForm,
        GetCreditDetailsView $getCreditDetailsView
    ): JsonResponse
    {
        return $getCreditDetailsForm->makeResponse($request, $getCreditDetailsView);
    }

    #[Route('/credits/{id}', name: 'delete_credit', methods: ['DELETE'])]
    public function delete_credit(
        Request          $request,
        DeleteCreditForm $deleteCreditForm,
    ): JsonResponse
    {
        return $deleteCreditForm->makeResponse($request);
    }

}
