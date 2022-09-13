<?php
//new Assert\Choice(choices: ['open', 'waiting', 'paid', 'sent', 'received']),
namespace App\Form\Order;

use App\Lib\Form\ABaseForm;
use App\Repository\OrderRepository;

class GetOrdersForm extends ABaseForm
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    )
    {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(array $form): array
    {
        $user = $this->getUser();
////        $user = $this->userRepository
////            ->findOneBy(["phone_number" => $user_phone]);
//
//        if (!$user) {
//            throw new BadRequestHttpException("JWT Token Expired");
//        }

        return $this->orderRepository
            ->findBy(["user" => $user->getId()]);
    }
}
