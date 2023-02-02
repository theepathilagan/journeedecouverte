<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $min_points;

    #[ORM\OneToMany(mappedBy: 'niveau_id', targetEntity: User::class)]
    private $users;

    #[ORM\OneToMany(mappedBy: 'niveau_minimum', targetEntity: JourneeDecouverte::class)]
    private $journeeDecouvertes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->journeeDecouvertes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMinPoints(): ?int
    {
        return $this->min_points;
    }

    public function setMinPoints(?int $min_points): self
    {
        $this->min_points = $min_points;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setNiveauId($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getNiveauId() === $this) {
                $user->setNiveauId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|JourneeDecouverte[]
     */
    public function getJourneeDecouvertes(): Collection
    {
        return $this->journeeDecouvertes;
    }

    public function addJourneeDecouverte(JourneeDecouverte $journeeDecouverte): self
    {
        if (!$this->journeeDecouvertes->contains($journeeDecouverte)) {
            $this->journeeDecouvertes[] = $journeeDecouverte;
            $journeeDecouverte->setNiveauMinimum($this);
        }

        return $this;
    }

    public function removeJourneeDecouverte(JourneeDecouverte $journeeDecouverte): self
    {
        if ($this->journeeDecouvertes->removeElement($journeeDecouverte)) {
            // set the owning side to null (unless already changed)
            if ($journeeDecouverte->getNiveauMinimum() === $this) {
                $journeeDecouverte->setNiveauMinimum(null);
            }
        }

        return $this;
    }
}
