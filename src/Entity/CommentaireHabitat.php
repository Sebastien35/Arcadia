<?php

namespace App\Entity;

use App\Repository\CommentaireHabitatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireHabitatRepository::class)]
class CommentaireHabitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaire = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;


    #[ORM\ManyToOne(inversedBy: 'commentaireHabitats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habitat $Habitat = null;

    #[ORM\ManyToOne(inversedBy: 'commentaireHabitats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $auteur = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

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
