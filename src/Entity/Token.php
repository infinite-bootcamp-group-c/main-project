<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\TokenRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userID = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column]
    private ?DateTimeImmutable $expiresAt = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    // TODO:: ADD ENUM
    #[ORM\Column(type: 'string', columnDefinition: "ENUM('refresh_token', 'otp')")]
    private ?string $type = null;

}
