<?php

namespace App\Entity;

use App\Repository\PDossierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PDossierRepository::class)
 */
class PDossier
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
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $abreviation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=PArticle::class, mappedBy="dossier")
     */
    private $pArticles;

    /**
     * @ORM\OneToMany(targetEntity=TStock::class, mappedBy="dossier")
     */
    private $tStocks;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pDossiers")
     */
    private $userCreate;

    /**
     * @ORM\OneToMany(targetEntity=VLivraisoncab::class, mappedBy="dossier")
     */
    private $vLivraisoncabs;

    /**
     * @ORM\OneToMany(targetEntity=TOperationVente::class, mappedBy="dossier")
     */
    private $tOperationVentes;

    /**
     * @ORM\OneToMany(targetEntity=PProduit::class, mappedBy="dossier")
     */
    private $pProduits;

    /**
     * @ORM\OneToMany(targetEntity=TDetailVente::class, mappedBy="dossier")
     */
    private $tDetailVentes;

    /**
     * @ORM\OneToMany(targetEntity=UserAffectation::class, mappedBy="dossier")
     */
    private $userAffectations;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idUgouv;

    /**
     * @ORM\OneToMany(targetEntity=PClient::class, mappedBy="Dossier")
     */
    private $pClients;

    public function __construct()
    {
        $this->pArticles = new ArrayCollection();
        $this->tStocks = new ArrayCollection();
        $this->vLivraisoncabs = new ArrayCollection();
        $this->tOperationVentes = new ArrayCollection();
        $this->pProduits = new ArrayCollection();
        $this->tDetailVentes = new ArrayCollection();
        $this->userAffectations = new ArrayCollection();
        $this->pClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(string $abreviation): self
    {
        $this->abreviation = $abreviation;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|PArticle[]
     */
    public function getPArticles(): Collection
    {
        return $this->pArticles;
    }

    public function addPArticle(PArticle $pArticle): self
    {
        if (!$this->pArticles->contains($pArticle)) {
            $this->pArticles[] = $pArticle;
            $pArticle->setDossier($this);
        }

        return $this;
    }

    public function removePArticle(PArticle $pArticle): self
    {
        if ($this->pArticles->removeElement($pArticle)) {
            // set the owning side to null (unless already changed)
            if ($pArticle->getDossier() === $this) {
                $pArticle->setDossier(null);
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
            $tStock->setDossier($this);
        }

        return $this;
    }

    public function removeTStock(TStock $tStock): self
    {
        if ($this->tStocks->removeElement($tStock)) {
            // set the owning side to null (unless already changed)
            if ($tStock->getDossier() === $this) {
                $tStock->setDossier(null);
            }
        }

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

    /**
     * @return Collection|VLivraisoncab[]
     */
    public function getVLivraisoncabs(): Collection
    {
        return $this->vLivraisoncabs;
    }

    public function addVLivraisoncab(VLivraisoncab $vLivraisoncab): self
    {
        if (!$this->vLivraisoncabs->contains($vLivraisoncab)) {
            $this->vLivraisoncabs[] = $vLivraisoncab;
            $vLivraisoncab->setDossier($this);
        }

        return $this;
    }

    public function removeVLivraisoncab(VLivraisoncab $vLivraisoncab): self
    {
        if ($this->vLivraisoncabs->removeElement($vLivraisoncab)) {
            // set the owning side to null (unless already changed)
            if ($vLivraisoncab->getDossier() === $this) {
                $vLivraisoncab->setDossier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TOperationVente[]
     */
    public function getTOperationVentes(): Collection
    {
        return $this->tOperationVentes;
    }

    public function addTOperationVente(TOperationVente $tOperationVente): self
    {
        if (!$this->tOperationVentes->contains($tOperationVente)) {
            $this->tOperationVentes[] = $tOperationVente;
            $tOperationVente->setDossier($this);
        }

        return $this;
    }

    public function removeTOperationVente(TOperationVente $tOperationVente): self
    {
        if ($this->tOperationVentes->removeElement($tOperationVente)) {
            // set the owning side to null (unless already changed)
            if ($tOperationVente->getDossier() === $this) {
                $tOperationVente->setDossier(null);
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
            $pProduit->setDossier($this);
        }

        return $this;
    }

    public function removePProduit(PProduit $pProduit): self
    {
        if ($this->pProduits->removeElement($pProduit)) {
            // set the owning side to null (unless already changed)
            if ($pProduit->getDossier() === $this) {
                $pProduit->setDossier(null);
            }
        }

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
            $tDetailVente->setDossier($this);
        }

        return $this;
    }

    public function removeTDetailVente(TDetailVente $tDetailVente): self
    {
        if ($this->tDetailVentes->removeElement($tDetailVente)) {
            // set the owning side to null (unless already changed)
            if ($tDetailVente->getDossier() === $this) {
                $tDetailVente->setDossier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserAffectation[]
     */
    public function getUserAffectations(): Collection
    {
        return $this->userAffectations;
    }

    public function addUserAffectation(UserAffectation $userAffectation): self
    {
        if (!$this->userAffectations->contains($userAffectation)) {
            $this->userAffectations[] = $userAffectation;
            $userAffectation->setDossier($this);
        }

        return $this;
    }

    public function removeUserAffectation(UserAffectation $userAffectation): self
    {
        if ($this->userAffectations->removeElement($userAffectation)) {
            // set the owning side to null (unless already changed)
            if ($userAffectation->getDossier() === $this) {
                $userAffectation->setDossier(null);
            }
        }

        return $this;
    }

    public function getIdUgouv(): ?int
    {
        return $this->idUgouv;
    }

    public function setIdUgouv(?int $idUgouv): self
    {
        $this->idUgouv = $idUgouv;

        return $this;
    }

    /**
     * @return Collection|PClient[]
     */
    public function getPClients(): Collection
    {
        return $this->pClients;
    }

    public function addPClient(PClient $pClient): self
    {
        if (!$this->pClients->contains($pClient)) {
            $this->pClients[] = $pClient;
            $pClient->setDossier($this);
        }

        return $this;
    }

    public function removePClient(PClient $pClient): self
    {
        if ($this->pClients->removeElement($pClient)) {
            // set the owning side to null (unless already changed)
            if ($pClient->getDossier() === $this) {
                $pClient->setDossier(null);
            }
        }

        return $this;
    }
}
