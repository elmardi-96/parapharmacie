<?php

namespace App\Entity;

use App\Repository\PArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PArticleRepository::class)
 */
class PArticle
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $abreviation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=PDossier::class, inversedBy="pArticles")
     */
    private $dossier;

    /**
     * @ORM\OneToMany(targetEntity=TStock::class, mappedBy="article")
     */
    private $tStocks;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pArticles")
     */
    private $userCreate;

    /**
     * @ORM\OneToMany(targetEntity=PProduit::class, mappedBy="article")
     */
    private $pProduits;

    public function __construct()
    {
        $this->tStocks = new ArrayCollection();
        $this->pProduits = new ArrayCollection();
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

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(?string $abreviation): self
    {
        $this->abreviation = $abreviation;

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
            $tStock->setArticle($this);
        }

        return $this;
    }

    public function removeTStock(TStock $tStock): self
    {
        if ($this->tStocks->removeElement($tStock)) {
            // set the owning side to null (unless already changed)
            if ($tStock->getArticle() === $this) {
                $tStock->setArticle(null);
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
            $pProduit->setArticle($this);
        }

        return $this;
    }

    public function removePProduit(PProduit $pProduit): self
    {
        if ($this->pProduits->removeElement($pProduit)) {
            // set the owning side to null (unless already changed)
            if ($pProduit->getArticle() === $this) {
                $pProduit->setArticle(null);
            }
        }

        return $this;
    }
}
