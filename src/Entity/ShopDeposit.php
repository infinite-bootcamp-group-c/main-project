<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\ShopDepositRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopDepositRepository::class)]
class ShopDeposit
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shop $shopId = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $receipt = null;

    #[ORM\Column]
    private ?DateTimeImmutable $paidAt = null;
}
