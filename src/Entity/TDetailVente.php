<?php

namespace App\Entity;

use App\Repository\TDetailVenteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TDetailVenteRepository::class)
 */
class TDetailVente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tva;

    /**
     * @ORM\ManyToOne(targetEntity=PProduit::class, inversedBy="tDetailVentes")
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=TOperationVente::class, inversedBy="tDetailVentes")
     */
    private $oprationVente;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixUnitaire;

    /**
     * @ORM\Column(type="float")
     */
    private $prixTtc;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tDetailVentes")
     */
    private $userCreate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=PDossier::class, inversedBy="tDetailVentes")
     */
    private $dossier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getProduit(): ?PProduit
    {
        return $this->produit;
    }

    public function setProduit(?PProduit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getOprationVente(): ?TOperationVente
    {
        return $this->oprationVente;
    }

    public function setOprationVente(?TOperationVente $oprationVente): self
    {
        $this->oprationVente = $oprationVente;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(?float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getPrixTtc(): ?float
    {
        return $this->prixTtc;
    }

    public function setPrixTtc(float $prixTtc): self
    {
        $this->prixTtc = $prixTtc;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

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

    public function getUserCreate(): ?User
    {
        return $this->userCreate;
    }

    public function setUserCreate(?User $userCreate): self
    {
        $this->userCreate = $userCreate;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(?float $quantite): self
    {
        $this->quantite = $quantite;

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
}
