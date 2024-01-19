<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbClicks = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private array $race = [];

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $image = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Habitat $Habitat = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private array $etat = [];

    #[ORM\Column]
    private array $nourriture = [];

    #[ORM\Column(nullable: true)]
    private ?int $grammage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDePassage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $detailEtatAnimal = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?zoo $zoo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbClicks(): ?int
    {
        return $this->nbClicks;
    }

    public function setNbClicks(?int $nbClicks): static
    {
        $this->nbClicks = $nbClicks;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRace(): array
    {
        return $this->race;
    }

    public function setRace(array $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getHabitat(): ?Habitat
    {
        return $this->Habitat;
    }

    public function setHabitat(?Habitat $Habitat): static
    {
        $this->Habitat = $Habitat;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getEtat(): array
    {
        return $this->etat;
    }

    public function setEtat(array $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getNourriture(): array
    {
        return $this->nourriture;
    }

    public function setNourriture(array $nourriture): static
    {
        $this->nourriture = $nourriture;

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

    public function getDateDePassage(): ?\DateTimeInterface
    {
        return $this->dateDePassage;
    }

    public function setDateDePassage(?\DateTimeInterface $dateDePassage): static
    {
        $this->dateDePassage = $dateDePassage;

        return $this;
    }

    public function getDetailEtatAnimal(): ?\DateTimeInterface
    {
        return $this->detailEtatAnimal;
    }

    public function setDetailEtatAnimal(?\DateTimeInterface $detailEtatAnimal): static
    {
        $this->detailEtatAnimal = $detailEtatAnimal;

        return $this;
    }

    public function getZoo(): ?zoo
    {
        return $this->zoo;
    }

    public function setZoo(?zoo $zoo): static
    {
        $this->zoo = $zoo;

        return $this;
    }

    public function __construct( 
        string $prenom,
        string $nom,
        array $race,
        $image,
        Habitat $Habitat,
        array $etat,
        array $nourriture,
        int $grammage,
        \DateTimeInterface $dateDePassage,
        \DateTimeInterface $detailEtatAnimal,
        zoo $zoo
    )
    {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->race = $race;
        $this->image = $image;
        $this->Habitat = $Habitat;
        $this->etat = $etat;
        $this->nourriture = $nourriture;
        $this->grammage = $grammage;
        $this->dateDePassage = $dateDePassage;
        $this->detailEtatAnimal = $detailEtatAnimal;
        $this->zoo = $zoo;
        $this->createdAt = new \DateTimeImmutable();
        
    }

    
}
