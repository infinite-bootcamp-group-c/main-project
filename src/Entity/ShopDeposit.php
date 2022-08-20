<?php

namespace App\Entity;

use App\Repository\ShopDepositRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopDepositRepository::class)]
class ShopDeposit
{
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
    private ?\DateTimeImmutable $paidAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopId(): ?Shop
    {
        return $this->shopId;
    }

    public function setShopId(?Shop $shopId): self
    {
        $this->shopId = $shopId;

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

    public function getReceipt(): ?string
    {
        return $this->receipt;
    }

    public function setReceipt(?string $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    public function getPaidAt(): ?\DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function setPaidAt(\DateTimeImmutable $paidAt): self
    {
        $this->paidAt = $paidAt;

        return $this;
    }
}
