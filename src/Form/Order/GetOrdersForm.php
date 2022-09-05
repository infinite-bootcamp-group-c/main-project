<?php
//new Assert\Choice(choices: ['open', 'waiting', 'paid', 'sent', 'received']),
namespace App\Form\Order;

use App\Lib\Form\ABaseForm;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetOrdersForm extends ABaseForm
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly OrderRepository $orderRepository
    ) {

    }

    public function constraints(): array
    {
        return [];
    }

    public function execute(Request $request): array
    {
        $user_phone = $this->getUser()->getUserIdentifier();
        $user = $this->userRepository
            ->findOneBy(["phone_number" => $user_phone]);

        if (!$user) {
            throw new BadRequestHttpException("JWT Token Expired");
        }

        return $this->orderRepository
            ->findBy(["user_id" => $user->getId()]);
    }
}