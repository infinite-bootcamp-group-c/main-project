<?php

namespace App\Entity;

use App\Repository\OrderTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderTransactionRepository::class)]
class OrderTransaction
{
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopDepositId(): ?ShopDeposit
    {
        return $this->shopDepositId;
    }

    public function setShopDepositId(?ShopDeposit $shopDepositId): self
    {
        $this->shopDepositId = $shopDepositId;

        return $this;
    }

    public function getOrderId(): ?Order
    {
        return $this->orderId;
    }

    public function setOrderId(Order $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPayementVerificationCode(): ?string
    {
        return $this->payementVerificationCode;
    }

    public function setPayementVerificationCode(?string $payementVerificationCode): self
    {
        $this->payementVerificationCode = $payementVerificationCode;

        return $this;
    }
}
