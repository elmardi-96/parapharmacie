<?php

namespace App\Entity;

use App\Repository\VLivraisoncabRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VLivraisoncabRepository::class)
 */
class VLivraisoncab
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
    private $codeLivraison;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $refDocAsso;

    /**
     * @ORM\ManyToOne(targetEntity=PFornisseur::class, inversedBy="vLivraisoncabs")
     */
    private $fournisseur;

    /**
     * @ORM\ManyToOne(targetEntity=PClient::class, inversedBy="vLivraisoncabs")
     */
    private $client;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateLivraison;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remise;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateRemise;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $mtRemise;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOperation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vLivraisoncabs")
     */
    private $userCreate;

    /**
     * @ORM\ManyToOne(targetEntity=PDossier::class, inversedBy="vLivraisoncabs")
     */
    private $dossier;

    /**
     * @ORM\OneToMany(targetEntity=VLivraisondet::class, mappedBy="livraisoncab")
     */
    private $vLivraisondets;

    /**
     * @ORM\OneToMany(targetEntity=PProduit::class, mappedBy="livraisoncab")
     */
    private $pProduits;

    /**
     * @ORM\OneToMany(targetEntity=TStock::class, mappedBy="livraisoncab")
     */
    private $tStocks;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idDossierUgouv;

    public function __construct()
    {
        $this->vLivraisondets = new ArrayCollection();
        $this->pProduits = new ArrayCollection();
        $this->tStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeLivraison(): ?string
    {
        return $this->codeLivraison;
    }

    public function setCodeLivraison(?string $codeLivraison): self
    {
        $this->codeLivraison = $codeLivraison;

        return $this;
    }

    public function getRefDocAsso(): ?string
    {
        return $this->refDocAsso;
    }

    public function setRefDocAsso(?string $refDocAsso): self
    {
        $this->refDocAsso = $refDocAsso;

        return $this;
    }

    public function getFournisseur(): ?PFornisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?PFornisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getClient(): ?PClient
    {
        return $this->client;
    }

    public function setClient(?PClient $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(?\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getRemise(): ?string
    {
        return $this->remise;
    }

    public function setRemise(?string $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getDateRemise(): ?\DateTimeInterface
    {
        return $this->dateRemise;
    }

    public function setDateRemise(?\DateTimeInterface $dateRemise): self
    {
        $this->dateRemise = $dateRemise;

        return $this;
    }

    public function getMtRemise(): ?float
    {
        return $this->mtRemise;
    }

    public function setMtRemise(?float $mtRemise): self
    {
        $this->mtRemise = $mtRemise;

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
     * @return Collection|VLivraisondet[]
     */
    public function getVLivraisondets(): Collection
    {
        return $this->vLivraisondets;
    }

    public function addVLivraisondet(VLivraisondet $vLivraisondet): self
    {
        if (!$this->vLivraisondets->contains($vLivraisondet)) {
            $this->vLivraisondets[] = $vLivraisondet;
            $vLivraisondet->setLivraisoncab($this);
        }

        return $this;
    }

    public function removeVLivraisondet(VLivraisondet $vLivraisondet): self
    {
        if ($this->vLivraisondets->removeElement($vLivraisondet)) {
            // set the owning side to null (unless already changed)
            if ($vLivraisondet->getLivraisoncab() === $this) {
                $vLivraisondet->setLivraisoncab(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PProduit[]
     */
    public function getPProduits(): Collection
    {
        return $this->pProduits;
    }

    public function addPProduit(PProduit $pProduit): self
    {
        if (!$this->pProduits->contains($pProduit)) {
            $this->pProduits[] = $pProduit;
            $pProduit->setLivraisoncab($this);
        }

        return $this;
    }

    public function removePProduit(PProduit $pProduit): self
    {
        if ($this->pProduits->removeElement($pProduit)) {
            // set the owning side to null (unless already changed)
            if ($pProduit->getLivraisoncab() === $this) {
                $pProduit->setLivraisoncab(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TStock[]
     */
    public function getTStocks(): Collection
    {
        return $this->tStocks;
    }

    public function addTStock(TStock $tStock): self
    {
        if (!$this->tStocks->contains($tStock)) {
            $this->tStocks[] = $tStock;
            $tStock->setLivraisoncab($this);
        }

        return $this;
    }

    public function removeTStock(TStock $tStock): self
    {
        if ($this->tStocks->removeElement($tStock)) {
            // set the owning side to null (unless already changed)
            if ($tStock->getLivraisoncab() === $this) {
                $tStock->setLivraisoncab(null);
            }
        }

        return $this;
    }

    public function getIdDossierUgouv(): ?int
    {
        return $this->idDossierUgouv;
    }

    public function setIdDossierUgouv(?int $idDossierUgouv): self
    {
        $this->idDossierUgouv = $idDossierUgouv;

        return $this;
    }
}
