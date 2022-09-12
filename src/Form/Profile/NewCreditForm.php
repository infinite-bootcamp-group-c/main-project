<?php

namespace App\Form\Profile;

use App\Entity\CreditInfo;
use App\Lib\Form\ABaseForm;
use App\Repository\CreditInfoRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class NewCreditForm extends ABaseForm
{
    public function __construct(
        private readonly CreditInfoRepository $creditInfoRepository,
        private readonly UserRepository       $userRepository
    )
    {

    }

    public function constraints(): array
    {
        return [
            "body" => [
                "card" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length(
                        exactly: 16, exactMessage: "card number must be 16 characters long"
                    )
                ],
                "IBAN" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length(
                        exactly: 26, exactMessage: "IBAN must be 26 characters long"
                    )
                ],
                "expires_at" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\DateTime()
                ]
            ]
        ];
    }

    public function execute(array $form): CreditInfo
    {
        $user_phone = $this->getUser()->getUserIdentifier();
        $user = $this->userRepository
            ->findOneBy(["phoneNumber" => $user_phone]);

        if (!$user) {
            throw new BadRequestHttpException("JWT Token Expired");
        }

        $expires_at = null;
        try {
            $expires_at = new DateTimeImmutable($form["body"]["expires_at"]);
        } catch (Exception $exception) {
            throw $exception;
        }

        $creditInfo = (new CreditInfo())
            ->setCard($form["body"]["card"])
            ->setIBAN($form["body"]["IBAN"])
            ->setExpiresAt($expires_at)
            ->setUser($user);

        $this->creditInfoRepository->add($creditInfo);
        $user->addCreditInfo($creditInfo);

        $this->creditInfoRepository->flush();
        $this->userRepository->flush();

        return $creditInfo;
    }
}
