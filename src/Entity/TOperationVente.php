<?php

namespace App\Entity;

use App\Repository\TOperationVenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TOperationVenteRepository::class)
 */
class TOperationVente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateVente;

    /**
     * @ORM\ManyToOne(targetEntity=PClient::class, inversedBy="tOperationVentes")
     */
    private $client;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tOperationVentes")
     */
    private $userCreate;

    /**
     * @ORM\ManyToOne(targetEntity=PDossier::class, inversedBy="tOperationVentes")
     */
    private $dossier;

    /**
     * @ORM\OneToMany(targetEntity=TDetailVente::class, mappedBy="oprationVente")
     */
    private $tDetailVentes;

    public function __construct()
    {
        $this->tDetailVentes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVente(): ?\DateTimeInterface
    {
        return $this->dateVente;
    }

    public function setDateVente(?\DateTimeInterface $dateVente): self
    {
        $this->dateVente = $dateVente;

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
            $tDetailVente->setOprationVente($this);
        }

        return $this;
    }

    public function removeTDetailVente(TDetailVente $tDetailVente): self
    {
        if ($this->tDetailVentes->removeElement($tDetailVente)) {
            // set the owning side to null (unless already changed)
            if ($tDetailVente->getOprationVente() === $this) {
                $tDetailVente->setOprationVente(null);
            }
        }

        return $this;
    }
}
