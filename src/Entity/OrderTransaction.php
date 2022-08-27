<?php

namespace App\Entity;

use App\Entity\Enums\OrderTransactionStatus;
use App\Entity\Traits\HasTimestamp;
use App\Repository\OrderTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderTransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class OrderTransaction
{
    use HasTimestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShopDeposit $shopDeposit = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $paymentMethod = null;

    #[ORM\Column(type: 'smallint', enumType: OrderTransactionStatus::class)]
    private ?OrderTransactionStatus $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $paymentVerificationCode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopDeposit(): ?ShopDeposit
    {
        return $this->shopDeposit;
    }

    public function setShopDeposit(?ShopDeposit $shopDeposit): self
    {
        $this->shopDeposit = $shopDeposit;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;

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

    public function getPaymentVerificationCode(): ?string
    {
        return $this->paymentVerificationCode;
    }

    public function setPaymentVerificationCode(?string $paymentVerificationCode): self
    {
        $this->paymentVerificationCode = $paymentVerificationCode;

        return $this;
    }
}
