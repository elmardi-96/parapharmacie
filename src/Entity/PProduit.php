<?php

namespace App\Entity;

use App\Repository\PProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PProduitRepository::class)
 */
class PProduit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $designation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixAchat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PrixVente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nLot;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateExp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeBarre;

    /**
     * @ORM\ManyToOne(targetEntity=VLivraisoncab::class, inversedBy="pProduits")
     */
    private $livraisoncab;

    /**
     * @ORM\ManyToOne(targetEntity=PArticle::class, inversedBy="pProduits")
     */
    private $article;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tva;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pProduits")
     */
    private $userCreation;

    /**
     * @ORM\ManyToOne(targetEntity=PDossier::class, inversedBy="pProduits")
     */
    private $dossier;

    /**
     * @ORM\OneToMany(targetEntity=TDetailVente::class, mappedBy="produit")
     */
    private $tDetailVentes;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $qte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $conditionnement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeZone;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $qteReste;

    /**
     * @ORM\OneToOne(targetEntity=VLivraisondet::class, inversedBy="pProduit", cascade={"persist", "remove"})
     */
    private $Livraisondet;


    public function __construct()
    {
        $this->tDetailVentes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(?float $prixAchat): self
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->PrixVente;
    }

    public function setPrixVente(?float $PrixVente): self
    {
        $this->PrixVente = $PrixVente;

        return $this;
    }

    public function getNLot(): ?string
    {
        return $this->nLot;
    }

    public function setNLot(?string $nLot): self
    {
        $this->nLot = $nLot;

        return $this;
    }

    public function getDateExp(): ?\DateTimeInterface
    {
        return $this->dateExp;
    }

    public function setDateExp(?\DateTimeInterface $dateExp): self
    {
        $this->dateExp = $dateExp;

        return $this;
    }

    public function getCodeBarre(): ?string
    {
        return $this->codeBarre;
    }

    public function setCodeBarre(?string $codeBarre): self
    {
        $this->codeBarre = $codeBarre;

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

    public function getArticle(): ?PArticle
    {
        return $this->article;
    }

    public function setArticle(?PArticle $article): self
    {
        $this->article = $article;

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getUserCreation(): ?User
    {
        return $this->userCreation;
    }

    public function setUserCreation(?User $userCreation): self
    {
        $this->userCreation = $userCreation;

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

    /**
     * @return Collection|TDetailVente[]
     */
    public function getTDetailVentes(): Collection
    {
        return $this->tDetailVentes;
    }

    public function addTDetailVente(TDetailVente $tDetailVente): self
    {
        if (!$this->tDetailVentes->contains($tDetailVente)) {
            $this->tDetailVentes[] = $tDetailVente;
            $tDetailVente->setProduit($this);
        }

        return $this;
    }

    public function removeTDetailVente(TDetailVente $tDetailVente): self
    {
        if ($this->tDetailVentes->removeElement($tDetailVente)) {
            // set the owning side to null (unless already changed)
            if ($tDetailVente->getProduit() === $this) {
                $tDetailVente->setProduit(null);
            }
        }

        return $this;
    }

    public function getQte(): ?float
    {
        return $this->qte;
    }

    public function setQte(?float $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getConditionnement(): ?string
    {
        return $this->conditionnement;
    }

    public function setConditionnement(?string $conditionnement): self
    {
        $this->conditionnement = $conditionnement;

        return $this;
    }

    public function getCodeZone(): ?string
    {
        return $this->codeZone;
    }

    public function setCodeZone(?string $codeZone): self
    {
        $this->codeZone = $codeZone;

        return $this;
    }

    public function getQteReste(): ?float
    {
        return $this->qteReste;
    }

    public function setQteReste(?float $qteReste): self
    {
        $this->qteReste = $qteReste;

        return $this;
    }

    public function getLivraisondet(): ?VLivraisondet
    {
        return $this->Livraisondet;
    }

    public function setLivraisondet(?VLivraisondet $Livraisondet): self
    {
        $this->Livraisondet = $Livraisondet;

        return $this;
    }
}
