<?php

namespace App\Repository;

use App\Entity\CreditInfo;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class CreditInfoRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditInfo::class);
    }
}
