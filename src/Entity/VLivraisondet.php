<?php

namespace App\Entity;

use App\Repository\VLivraisondetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VLivraisondetRepository::class)
 */
class VLivraisondet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=VLivraisoncab::class, inversedBy="vLivraisondets")
     */
    private $livraisoncab;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $article;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $unite;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priUnitaire;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tva;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixTtc;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOperation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vLivraisondets")
     */
    private $userCreate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idEgouv;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $enStock;

    /**
     * @ORM\OneToOne(targetEntity=PProduit::class, mappedBy="Livraisondet", cascade={"persist", "remove"})
     */
    private $pProduit;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(?string $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(?string $unite): self
    {
        $this->unite = $unite;

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

    public function getPriUnitaire(): ?float
    {
        return $this->priUnitaire;
    }

    public function setPriUnitaire(?float $priUnitaire): self
    {
        $this->priUnitaire = $priUnitaire;

        return $this;
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

    public function getPrixTtc(): ?float
    {
        return $this->prixTtc;
    }

    public function setPrixTtc(?float $prixTtc): self
    {
        $this->prixTtc = $prixTtc;

        return $this;
    }

    public function getDateOperation(): ?\DateTimeInterface
    {
        return $this->dateOperation;
    }

    public function setDateOperation(?\DateTimeInterface $dateOperation): self
    {
        $this->dateOperation = $dateOperation;

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

    public function getIdEgouv(): ?int
    {
        return $this->idEgouv;
    }

    public function setIdEgouv(?int $idEgouv): self
    {
        $this->idEgouv = $idEgouv;

        return $this;
    }

    public function getEnStock(): ?int
    {
        return $this->enStock;
    }

    public function setEnStock(?int $enStock): self
    {
        $this->enStock = $enStock;

        return $this;
    }

    public function getPProduit(): ?PProduit
    {
        return $this->pProduit;
    }

    public function setPProduit(?PProduit $pProduit): self
    {
        // unset the owning side of the relation if necessary
        if ($pProduit === null && $this->pProduit !== null) {
            $this->pProduit->setLivraisondet(null);
        }

        // set the owning side of the relation if necessary
        if ($pProduit !== null && $pProduit->getLivraisondet() !== $this) {
            $pProduit->setLivraisondet($this);
        }

        $this->pProduit = $pProduit;

        return $this;
    }
}
