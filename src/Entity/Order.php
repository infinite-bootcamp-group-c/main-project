<?php

namespace App\Entity;

use App\Entity\Enums\OrderStatus;
use App\Entity\Traits\HasTimestamp;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`order`')]
class Order
{
    use HasTimestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'smallint', enumType: OrderStatus::class)]
    private ?OrderStatus $status = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: "Shop")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shop $shop = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalPrice = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class)]
    private Collection $items;

//    #[ORM\ManyToMany(targetEntity: 'Address')]
//    #[ORM\JoinTable(name: 'orders_addresses')]
//    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id')]
//    #[ORM\InverseJoinColumn(name: 'address_id', referencedColumnName: 'id', unique: true)]
//    private Collection $addresses;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Address $address = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): int
    {
        return $this->status->name;
    }

    public function setStatus(OrderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): self
    {
        $this->shop = $shop;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrder($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrder() === $this) {
                $item->setOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
//    public function getAddresses(): Collection
//    {
//        return $this->addresses;
//    }
//
//    public function addAddress(Address $address): self
//    {
//        if (!$this->addresses->contains($address)) {
//            $this->addresses->add($address);
//        }
//
//        return $this;
//    }

//    public function removeAddress(Address $address): self
//    {
//        $this->addresses->removeElement($address);
//
//        return $this;
//    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getAddress(Address $address)
    {
        return $this->address;
    }
}
