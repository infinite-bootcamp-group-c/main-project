<?php

namespace App\Form\Shop;

use App\Entity\ShopDeposit;
use App\Form\Traits\HasValidateOwnership;
use App\Lib\Form\ABaseForm;
use App\Repository\OrderTransactionRepository;
use App\Repository\ShopDepositRepository;
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
        private readonly ShopDepositRepository $shopDepositRepository,
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

    public function execute(Request $request): void
    {
        $form = self::getParams($request);
        $shopId = $form['body']['shop_id'];
        $shop = $this->shopRepository->find($shopId);

        if (!$shop) {
            throw new NotFoundHttpException("Shop ${shopId} not found");
        }

        $this->validateOwnership($shop, $this->getUser()->getId());

        $qb = $this->orderTransactionRepository->createQueryBuilder('ot');

        $orderTransactionResult = $qb->select('ot.id', 'ot.amount')
            ->leftJoin('ot.order', 'o', 'WITH', 'ot.order = o.id')
            ->where('ot.shopDeposit IS NULL AND o.shop = :shop_id AND ot.status = 1')
            ->setParameter('shop_id', $shopId)
            ->getQuery()
            ->getResult();

        $sumOfDepositToShop = array_sum(array_column($orderTransactionResult, 'amount'));
        $orderTransactionId = array_column($orderTransactionResult, 'id');

        if($sumOfDepositToShop == 0) {
            throw new \Exception("Withdrawal is not possible for shop ${shopId}");
        }

        $shopDeposit = (new ShopDeposit())
            ->setAmount($sumOfDepositToShop)
            ->setShop($shop)
            ->setPaidAt(new \DateTimeImmutable());

        $this->shopDepositRepository->add($shopDeposit, true);

        $shopDepositId = $shopDeposit->getId();

        $this->orderTransactionRepository->createQueryBuilder('ot')
            ->update()
            ->set('ot.shopDeposit', ':shop_deposit_id')
            ->where('ot.id IN (:order_transaction_id)')
            ->setParameter('shop_deposit_id', $shopDepositId)
            ->setParameter('order_transaction_id', $orderTransactionId)
            ->getQuery()
            ->execute();
    }
}