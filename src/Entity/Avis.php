<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 4096)]
    private ?string $Avis_content = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column]
    private ?bool $validation = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Zoo $Zoo = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAvisContent(): ?string
    {
        return $this->Avis_content;
    }

    public function setAvisContent(string $Avis_content): static
    {
        $this->Avis_content = $Avis_content;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function isValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): static
    {
        $this->validation = $validation;

        return $this;
    }

    public function getZoo(): ?Zoo
    {
        return $this->Zoo;
    }

    public function setZoo(?Zoo $Zoo): static
    {
        $this->Zoo = $Zoo;

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


    public function __construct(
        string $pseudo,
        string $Avis_content,
        int $note,
        bool $validation,
        Zoo $Zoo,
        \DateTimeImmutable $createdAt
    ) {
        $this->pseudo = $pseudo;
        $this->Avis_content = $Avis_content;
        $this->note = $note;
        $this->validation = $validation;
        $this->Zoo = $Zoo;
        $this->createdAt = $createdAt;
    }
    
}
