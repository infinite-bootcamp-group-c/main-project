<?php

namespace App\Form\Shop;

use App\Entity\Shop;
use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\OrderRepository;
use App\Repository\OrderTransactionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ShopRepository;
use Symfony\Component\HttpFoundation\Request;


class DepositShopForm extends ABaseForm
{

    use HasValidateOwnership;

    public function __construct(
        private readonly ShopRepository $shopRepository,
        private readonly OrderTransactionRepository $orderTransactionRepository,
        private readonly OrderRepository $orderRepository,
    )
    {
    }

    public function constraints(): array
    {
        return [
            'body' => [
                'shop_id' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Positive(),
                    new Assert\Type('digit'),
                ],
            ],
        ];
    }

    public function execute(Request $request): Shop
    {
        $form = self::getParams($request);
        $shopId = $form['body']['shop_id'];
        $shop = $this->shopRepository->find($shopId);

        if (!$shop) {
            throw new NotFoundHttpException("Shop ${shopId} not found");
        }

        $this->ValidateOwnership($shop, $this->getUser()->getId()); // check ownership of the shop

        /*
         * SELECT
         * `order_transactions'.id,
         * `order_transactions`.amount
         * FROM `order_transactions`
         * LEFT JOIN `order` ON order_transactions`.order_id = `order`.id
         * WHERE shop_deposit_id = null AND `order`.shop_id = $shopId AND status = 'success'
         */

        $queryBuilder = $this->orderTransactionRepository
            ->createQueryBuilder('ot')
            ->select('ot.id', 'ot.amount')
            ->from('ot')
//            ->join('ot.order_id', 'order',
//                'WITH', 'ot.order_id = order.id')
            ->innerJoin('ot', 'order', 'o', 'ot.order_id = o.id')
            ->where('ot.shop_deposit_id = null AND order.shop_id = :shop_id AND ot.status = 1')
            ->setParameter('shop_id', $shop->getId());

        return $shop;
    }
}