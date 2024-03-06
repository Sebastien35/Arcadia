<?php

namespace App\Entity;

use App\Repository\InfoAnimalRepository;
use App\Entity\Nourriture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoAnimalRepository::class)]
class InfoAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $details = null;


    #[ORM\Column(nullable: true)]
    private ?int $grammage = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    /**
    * @ORM\ManyToOne(targetEntity="Nourriture", inversedBy="infoAnimals")
    * @ORM\JoinColumn(name="nourriture_id", referencedColumnName="id")
    */
    #[ORM\ManyToOne(targetEntity: Nourriture::class, inversedBy: 'infoAnimals')]
    private ?Nourriture $nourriture = null;

    #[ORM\ManyToOne(inversedBy: 'infoAnimals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'infoAnimals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $auteur = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }


    public function getGrammage(): ?int
    {
        return $this->grammage;
    }

    public function setGrammage(?int $grammage): static
    {
        $this->grammage = $grammage;

        return $this;
    }

    
    public function getNourriture(): ?Nourriture
    {
        return $this->nourriture;
    }

   public function setNourriture(Nourriture $nourriture): static
    {
        $this->nourriture = $nourriture;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAnimal(): ?animal
    {
        return $this->animal;
    }

    public function setAnimal(?animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    




}

