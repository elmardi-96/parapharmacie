<?php

namespace App\Entity;

use App\Repository\PClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PClientRepository::class)
 */
class PClient
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pClients")
     */
    private $userCreate;

    /**
     * @ORM\OneToMany(targetEntity=VLivraisoncab::class, mappedBy="client")
     */
    private $vLivraisoncabs;

    /**
     * @ORM\OneToMany(targetEntity=TOperationVente::class, mappedBy="client")
     */
    private $tOperationVentes;

    /**
     * @ORM\ManyToOne(targetEntity=PDossier::class, inversedBy="pClients")
     */
    private $Dossier;

    public function __construct()
    {
        $this->vLivraisoncabs = new ArrayCollection();
        $this->tOperationVentes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
            $vLivraisoncab->setClient($this);
        }

        return $this;
    }

    public function removeVLivraisoncab(VLivraisoncab $vLivraisoncab): self
    {
        if ($this->vLivraisoncabs->removeElement($vLivraisoncab)) {
            // set the owning side to null (unless already changed)
            if ($vLivraisoncab->getClient() === $this) {
                $vLivraisoncab->setClient(null);
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
            $tOperationVente->setClient($this);
        }

        return $this;
    }

    public function removeTOperationVente(TOperationVente $tOperationVente): self
    {
        if ($this->tOperationVentes->removeElement($tOperationVente)) {
            // set the owning side to null (unless already changed)
            if ($tOperationVente->getClient() === $this) {
                $tOperationVente->setClient(null);
            }
        }

        return $this;
    }

    public function getDossier(): ?PDossier
    {
        return $this->Dossier;
    }

    public function setDossier(?PDossier $Dossier): self
    {
        $this->Dossier = $Dossier;

        return $this;
    }
}
