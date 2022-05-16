<?php

namespace App\Entity;

use App\Repository\TStockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TStockRepository::class)
 */
class TStock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=PArticle::class, inversedBy="tStocks")
     */
    private $article;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=PDossier::class, inversedBy="tStocks")
     */
    private $dossier;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateModification;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tStocks")
     */
    private $userCreate;

    /**
     * @ORM\ManyToOne(targetEntity=VLivraisoncab::class, inversedBy="tStocks")
     */
    private $livraisoncab;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getArticle(): ?PArticle
    {
        return $this->article;
    }

    public function setArticle(?PArticle $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDossier(): ?PDossier
    {
        return $this->dossier;
    }

    public function setDossier(?PDossier $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(?\DateTimeInterface $dateModification): self
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    public function getUserCreate(): ?User
    {
        return $this->userCreate;
    }

    public function setUserCreate(?User $userCreate): self
    {
        $this->userCreate = $userCreate;

        return $this;
    }

    public function getLivraisoncab(): ?VLivraisoncab
    {
        return $this->livraisoncab;
    }

    public function setLivraisoncab(?VLivraisoncab $livraisoncab): self
    {
        $this->livraisoncab = $livraisoncab;

        return $this;
    }
}
