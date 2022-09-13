<?php

namespace App\Repository;

use App\Entity\ShopDeposit;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class ShopDepositRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopDeposit::class);
    }
}
