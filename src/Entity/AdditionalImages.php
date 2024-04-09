<?php

namespace App\Entity;

use App\Repository\AdditionalImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AdditionalImagesRepository::class)]
class AdditionalImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'additionalImages')]
    private ?Habitat $habitat = null;

    #[ORM\ManyToOne(inversedBy: 'additionalImages')]
    private ?Animal $animal = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Assert\File(maxSize: "10024k", mimeTypes: ["image/webp"], mimeTypesMessage: "Please upload a valid image file")]
    #[Vich\UploadableField(mapping: "additionnal_images", fileNameProperty: "imageName")]
    private $imageFile;

    #[ORM\Column(type: "string",length:255, nullable: true)]
    #[Groups(['image:read'])]
    private ?string $imageName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHabitat(): ?habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?habitat $habitat): static
    {
        $this->habitat = $habitat;

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

    
}
