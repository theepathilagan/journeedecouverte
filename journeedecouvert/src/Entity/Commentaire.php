<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $content;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commentaires')]
    private $user;

    #[ORM\ManyToOne(targetEntity: JourneeDecouverte::class, inversedBy: 'commentaires')]
    private $jd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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

    public function getJd(): ?JourneeDecouverte
    {
        return $this->jd;
    }

    public function setJd(?JourneeDecouverte $jd): self
    {
        $this->jd = $jd;

        return $this;
    }
}
