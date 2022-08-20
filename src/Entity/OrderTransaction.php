<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\OrderTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderTransactionRepository::class)]
class OrderTransaction
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShopDeposit $shopDepositId = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $orderId = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $paymentMethod = null;

    #[ORM\Column(type: 'string', columnDefinition: "ENUM('success', 'failed', 'waiting')")]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $payementVerificationCode = null;


}
