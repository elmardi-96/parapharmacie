<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=PArticle::class, mappedBy="userCreate")
     */
    private $pArticles;

    /**
     * @ORM\OneToMany(targetEntity=PDossier::class, mappedBy="userCreate")
     */
    private $pDossiers;

    /**
     * @ORM\OneToMany(targetEntity=PFornisseur::class, mappedBy="userCreate")
     */
    private $pFornisseurs;

    /**
     * @ORM\OneToMany(targetEntity=TStock::class, mappedBy="userCreate")
     */
    private $tStocks;

    /**
     * @ORM\OneToMany(targetEntity=PClient::class, mappedBy="userCreate")
     */
    private $pClients;

    /**
     * @ORM\OneToMany(targetEntity=VLivraisoncab::class, mappedBy="userCreate")
     */
    private $vLivraisoncabs;

    /**
     * @ORM\OneToMany(targetEntity=VLivraisondet::class, mappedBy="userCreate")
     */
    private $vLivraisondets;

    /**
     * @ORM\OneToMany(targetEntity=TOperationVente::class, mappedBy="userCreate")
     */
    private $tOperationVentes;

    /**
     * @ORM\OneToMany(targetEntity=PProduit::class, mappedBy="userCreation")
     */
    private $pProduits;

    /**
     * @ORM\OneToMany(targetEntity=TDetailVente::class, mappedBy="userCreate")
     */
    private $tDetailVentes;

    /**
     * @ORM\OneToMany(targetEntity=UserAffectation::class, mappedBy="user")
     */
    private $userAffectations;

    public function __construct()
    {
        $this->pArticles = new ArrayCollection();
        $this->pDossiers = new ArrayCollection();
        $this->pFornisseurs = new ArrayCollection();
        $this->tStocks = new ArrayCollection();
        $this->pClients = new ArrayCollection();
        $this->vLivraisoncabs = new ArrayCollection();
        $this->vLivraisondets = new ArrayCollection();
        $this->tOperationVentes = new ArrayCollection();
        $this->pProduits = new ArrayCollection();
        $this->tDetailVentes = new ArrayCollection();
        $this->userAffectations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $pArticle->setUserCreate($this);
        }

        return $this;
    }

    public function removePArticle(PArticle $pArticle): self
    {
        if ($this->pArticles->removeElement($pArticle)) {
            // set the owning side to null (unless already changed)
            if ($pArticle->getUserCreate() === $this) {
                $pArticle->setUserCreate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PDossier[]
     */
    public function getPDossiers(): Collection
    {
        return $this->pDossiers;
    }

    public function addPDossier(PDossier $pDossier): self
    {
        if (!$this->pDossiers->contains($pDossier)) {
            $this->pDossiers[] = $pDossier;
            $pDossier->setUserCreate($this);
        }

        return $this;
    }

    public function removePDossier(PDossier $pDossier): self
    {
        if ($this->pDossiers->removeElement($pDossier)) {
            // set the owning side to null (unless already changed)
            if ($pDossier->getUserCreate() === $this) {
                $pDossier->setUserCreate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PFornisseur[]
     */
    public function getPFornisseurs(): Collection
    {
        return $this->pFornisseurs;
    }

    public function addPFornisseur(PFornisseur $pFornisseur): self
    {
        if (!$this->pFornisseurs->contains($pFornisseur)) {
            $this->pFornisseurs[] = $pFornisseur;
            $pFornisseur->setUserCreate($this);
        }

        return $this;
    }

    public function removePFornisseur(PFornisseur $pFornisseur): self
    {
        if ($this->pFornisseurs->removeElement($pFornisseur)) {
            // set the owning side to null (unless already changed)
            if ($pFornisseur->getUserCreate() === $this) {
                $pFornisseur->setUserCreate(null);
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
            $tStock->setUserCreate($this);
        }

        return $this;
    }

    public function removeTStock(TStock $tStock): self
    {
        if ($this->tStocks->removeElement($tStock)) {
            // set the owning side to null (unless already changed)
            if ($tStock->getUserCreate() === $this) {
                $tStock->setUserCreate(null);
            }
        }

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
            $pClient->setUserCreate($this);
        }

        return $this;
    }

    public function removePClient(PClient $pClient): self
    {
        if ($this->pClients->removeElement($pClient)) {
            // set the owning side to null (unless already changed)
            if ($pClient->getUserCreate() === $this) {
                $pClient->setUserCreate(null);
            }
        }

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
            $vLivraisoncab->setUserCreate($this);
        }

        return $this;
    }

    public function removeVLivraisoncab(VLivraisoncab $vLivraisoncab): self
    {
        if ($this->vLivraisoncabs->removeElement($vLivraisoncab)) {
            // set the owning side to null (unless already changed)
            if ($vLivraisoncab->getUserCreate() === $this) {
                $vLivraisoncab->setUserCreate(null);
            }
        }

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
            $vLivraisondet->setUserCreate($this);
        }

        return $this;
    }

    public function removeVLivraisondet(VLivraisondet $vLivraisondet): self
    {
        if ($this->vLivraisondets->removeElement($vLivraisondet)) {
            // set the owning side to null (unless already changed)
            if ($vLivraisondet->getUserCreate() === $this) {
                $vLivraisondet->setUserCreate(null);
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
            $tOperationVente->setUserCreate($this);
        }

        return $this;
    }

    public function removeTOperationVente(TOperationVente $tOperationVente): self
    {
        if ($this->tOperationVentes->removeElement($tOperationVente)) {
            // set the owning side to null (unless already changed)
            if ($tOperationVente->getUserCreate() === $this) {
                $tOperationVente->setUserCreate(null);
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
            $pProduit->setUserCreation($this);
        }

        return $this;
    }

    public function removePProduit(PProduit $pProduit): self
    {
        if ($this->pProduits->removeElement($pProduit)) {
            // set the owning side to null (unless already changed)
            if ($pProduit->getUserCreation() === $this) {
                $pProduit->setUserCreation(null);
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
            $tDetailVente->setUserCreate($this);
        }

        return $this;
    }

    public function removeTDetailVente(TDetailVente $tDetailVente): self
    {
        if ($this->tDetailVentes->removeElement($tDetailVente)) {
            // set the owning side to null (unless already changed)
            if ($tDetailVente->getUserCreate() === $this) {
                $tDetailVente->setUserCreate(null);
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
            $userAffectation->setUser($this);
        }

        return $this;
    }

    public function removeUserAffectation(UserAffectation $userAffectation): self
    {
        if ($this->userAffectations->removeElement($userAffectation)) {
            // set the owning side to null (unless already changed)
            if ($userAffectation->getUser() === $this) {
                $userAffectation->setUser(null);
            }
        }

        return $this;
    }
}
