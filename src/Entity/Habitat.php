<?php

namespace App\Entity;

use App\Repository\HabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: HabitatRepository::class)]
class Habitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("animal:read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("animal:read")]
    private ?string $nom = null;

    #[ORM\Column(type: "string",length:255, nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: "habitat", fileNameProperty: "imageName")]
    private $imageFile;

    #[ORM\Column(length: 4096)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'Habitat', targetEntity: Animal::class)]
    private Collection $animals;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'habitat', targetEntity: CommentaireHabitat::class)]
    private Collection $commentaireHabitats;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->commentaireHabitats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setHabitat($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getHabitat() === $this) {
                $animal->setHabitat(null);
            }
        }

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

    /**
     * @return Collection<int, CommentaireHabitat>
     */
    public function getCommentaireHabitats(): Collection
    {
        return $this->commentaireHabitats;
    }

    public function addCommentaireHabitat(CommentaireHabitat $commentaireHabitat): static
    {
        if (!$this->commentaireHabitats->contains($commentaireHabitat)) {
            $this->commentaireHabitats->add($commentaireHabitat);
            $commentaireHabitat->setHabitat($this);
        }

        return $this;
    }

    public function removeCommentaireHabitat(CommentaireHabitat $commentaireHabitat): static
    {
        if ($this->commentaireHabitats->removeElement($commentaireHabitat)) {
            // set the owning side to null (unless already changed)
            if ($commentaireHabitat->getHabitat() === $this) {
                $commentaireHabitat->setHabitat(null);
            }
        }

        return $this;
    }
}
