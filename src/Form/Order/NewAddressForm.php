<?php

namespace App\Form\Order;

use App\Entity\Address;
use App\Lib\Form\ABaseForm;
use App\Repository\AddressRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class NewAddressForm extends ABaseForm
{
    public function __construct(
        private readonly UserRepository    $userRepository,
        private readonly OrderRepository   $orderRepository,
        private readonly AddressRepository $addressRepository,
    )
    {

    }

    public function constraints(): array
    {
        return [
            "body" => [
                "order_id" => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type("digit")
                ],
                "title" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(min: 4, max: 255),
                    new Assert\Regex(pattern: '/^\w+/'
                        , message: 'The shop name {{ value }} is not valid.'),
                ],
                "postal_code" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Type("digit")
                ],
                "province" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank()
                ],
                "address_details" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank()
                ],
                "country" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank()
                ],
                "city" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank()
                ],
                "latitude" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Type("float")
                ],
                "longitude" => [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Type("float")
                ],
                "save_address" => [
                    new Assert\NotNull(),
                    new Assert\Type("bool")
                ]
            ]
        ];
    }

    public function execute(Request $request): void
    {
        $body = self::getBodyParams($request);
        $user = $this->getUser();

        $order_id = $body["order_id"];
        $order = $this->orderRepository->find($order_id);
        if (!$order) {
            throw new BadRequestHttpException("Order id {$order_id} not found");
        }

        $address = (new Address())
            ->setTitle($body["title"])
            ->setPostalCode($body["postal_code"])
            ->setProvince($body["province"])
            ->setAddressDetails($body["address_details"])
            ->setCountry($body["country"])
            ->setCity($body["city"])
            ->setLatitude($body["latitude"])
            ->setLongitude($body["longitude"]);

        $this->addressRepository->add($address);

        if ($body["save_address"]) {
            $user->addAddress($address);
            $this->userRepository->flush();
        }

        $order->setAddress($address);
        $this->addressRepository->flush();
    }
}
