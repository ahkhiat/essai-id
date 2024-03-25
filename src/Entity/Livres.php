<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivresRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivresRepository::class)]
class Livres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getLivres", "getAuteurs"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getLivres", "getAuteurs"])]
    private ?string $Titre_livre = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getLivres", "getAuteurs"])]
    private ?string $Theme_livre = null;

    #[ORM\OneToMany(targetEntity: Commandes::class, mappedBy: 'livre')]
    // #[Groups(["getLivres", "getAuteurs"])]
    private Collection $commandes;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[Groups(["getLivres", "getAuteurs"])]
    private ?Auteurs $auteur = null;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreLivre(): ?string
    {
        return $this->Titre_livre;
    }

    public function setTitreLivre(string $Titre_livre): static
    {
        $this->Titre_livre = $Titre_livre;

        return $this;
    }

    public function getThemeLivre(): ?string
    {
        return $this->Theme_livre;
    }

    public function setThemeLivre(string $Theme_livre): static
    {
        $this->Theme_livre = $Theme_livre;

        return $this;
    }

    /**
     * @return Collection<int, Commandes>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commandes $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setLivre($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivre() === $this) {
                $commande->setLivre(null);
            }
        }

        return $this;
    }

    public function getAuteur(): ?Auteurs
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteurs $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }
}
