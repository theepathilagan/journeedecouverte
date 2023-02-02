<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'participations')]
    private $user;

    #[ORM\ManyToOne(targetEntity: JourneeDecouverte::class, inversedBy: 'participations')]
    private $jd;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $present;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getJd(): ?JourneeDecouverte
    {
        return $this->jd;
    }

    public function setJd(?JourneeDecouverte $jd): self
    {
        $this->jd = $jd;

        return $this;
    }

    public function getPresent(): ?bool
    {
        return $this->present;
    }

    public function setPresent(?bool $status): self
    {
        $this->present = $status;

        return $this;
    }
}
