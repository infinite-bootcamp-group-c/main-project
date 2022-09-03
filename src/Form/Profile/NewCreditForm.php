<?php

namespace App\Form\Profile;

use App\Entity\CreditInfo;
use App\Lib\Form\ABaseForm;
use App\Repository\CreditInfoRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class NewCreditForm extends ABaseForm
{
    public function __construct(
        private readonly CreditInfoRepository $creditInfoRepository,
        private readonly UserRepository $userRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

     public function execute(Request $request): CreditInfo
     {
         $form = self::getParams($request);

         $userId = $form["body"]["user_id"];
         $user = $this->userRepository
             ->find($userId);

         if (!$user) {
             throw new BadRequestException("Invalid user id");
         }

         $creditInfo = (new CreditInfo())
             ->setCard($form["body"]["card"])
             ->setIBAN($form["body"]["IBAN"])
             ->setExpiresAt($form["body"]["expires_at"]);
         $user->addCreditInfo($creditInfo);

         $this->creditInfoRepository->flush();
         $this->userRepository->flush();

         return $creditInfo;
     }
}