<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\InfoAnimal;


#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{   
    #[Groups("animal:read")]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups("animal:read")]
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[Groups("animal:read")]
    #[ORM\Column]
    private ?string $race = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[Groups("animal:read")]
    private ?Habitat $Habitat = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Vich\UploadableField(mapping: "animal", fileNameProperty: "imageName")]
    
    private $imageFile;

    #[ORM\Column(type: "string",length:255, nullable: true)]
    #[Groups("animal:read")]
    private ?string $imageName = null;

    

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: Repas::class)]
    private Collection $repas;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: InfoAnimal::class, orphanRemoval: true)]
    private Collection $infoAnimals;

    
    public function __construct()
    {
        $this->repas = new ArrayCollection();
        $this->infoAnimals = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

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


    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }


    /**
     * @return Collection<int, repas>
     */
    public function getRepas(): Collection
    {
        return $this->repas;
    }

    public function addRepa(repas $repa): static
    {
        if (!$this->repas->contains($repa)) {
            $this->repas->add($repa);
            $repa->setAnimal($this);
        }

        return $this;
    }

    public function removeRepa(repas $repa): static
    {
        if ($this->repas->removeElement($repa)) {
            // set the owning side to null (unless already changed)
            if ($repa->getAnimal() === $this) {
                $repa->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InfoAnimal>
     */
    public function getInfoAnimals(): Collection
    {
        return $this->infoAnimals;
    }

    public function addInfoAnimal(InfoAnimal $infoAnimal): static
    {
        if (!$this->infoAnimals->contains($infoAnimal)) {
            $this->infoAnimals->add($infoAnimal);
            $infoAnimal->setAnimal($this);
        }

        return $this;
    }

    public function removeInfoAnimal(InfoAnimal $infoAnimal): static
    {
        if ($this->infoAnimals->removeElement($infoAnimal)) {
            // set the owning side to null (unless already changed)
            if ($infoAnimal->getAnimal() === $this) {
                $infoAnimal->setAnimal(null);
            }
        }

        return $this;
    }




    

}
