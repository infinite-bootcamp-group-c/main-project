<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'userID', targetEntity: Shop::class, orphanRemoval: true)]
    private Collection $shops;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: CreditInfo::class, orphanRemoval: true)]
    private Collection $creditInfos;

    #[ORM\ManyToMany(targetEntity: 'Address')]
    #[ORM\JoinTable(name: 'users_addresses')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'address_id', referencedColumnName: 'id', unique: true)]
    private $addresses;

    public function __construct()
    {
        $this->shops = new ArrayCollection();
        $this->creditInfos = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    /**
     * @return Collection<int, Shop>
     */
    public function getShops(): Collection
    {
        return $this->shops;
    }

    public function addShop(Shop $shop): self
    {
        if (!$this->shops->contains($shop)) {
            $this->shops->add($shop);
            $shop->setUserID($this);
        }

        return $this;
    }

    public function removeShop(Shop $shop): self
    {
        if ($this->shops->removeElement($shop)) {
            // set the owning side to null (unless already changed)
            if ($shop->getUserID() === $this) {
                $shop->setUserID(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CreditInfo>
     */
    public function getCreditInfos(): Collection
    {
        return $this->creditInfos;
    }

    public function addCreditInfo(CreditInfo $creditInfo): self
    {
        if (!$this->creditInfos->contains($creditInfo)) {
            $this->creditInfos->add($creditInfo);
            $creditInfo->setUserId($this);
        }

        return $this;
    }

    public function removeCreditInfo(CreditInfo $creditInfo): self
    {
        if ($this->creditInfos->removeElement($creditInfo)) {
            // set the owning side to null (unless already changed)
            if ($creditInfo->getUserId() === $this) {
                $creditInfo->setUserId(null);
            }
        }

        return $this;
    }

}
