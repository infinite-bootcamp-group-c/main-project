<?php

namespace App\Repository;

use App\Entity\Address;
use App\Lib\Repository\ABaseRepository;
use App\Lib\Repository\IBaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends ABaseRepository implements IBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }
}


