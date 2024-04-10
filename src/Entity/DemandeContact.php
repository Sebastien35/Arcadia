<?php

namespace App\Entity;

use App\Repository\DemandeContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DemandeContactRepository::class)]
class DemandeContact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("demande:read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("demande:read")]
    private ?string $titre = null;

    #[Groups("demande:read")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[Groups("demande:read")]
    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[Groups("demande:read")]
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[Groups("demande:read")]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $answered_at = null;

    #[Groups("demande:read")]
    #[ORM\Column]
    private ?bool $answered = null;

    #[ORM\ManyToOne(inversedBy: 'demandeContacts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Zoo $zoo = null;

    public function getZoo(): ?ZOO
    {
        return $this->zoo;
    }
    public function setZoo(?ZOO $zoo): static
    {
        $this->zoo = $zoo;

        return $this;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $messaeg): static
    {
        $this->message = $messaeg;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

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

    public function getAnsweredAt(): ?\DateTimeImmutable
    {
        return $this->answered_at;
    }

    public function setAnsweredAt(?\DateTimeImmutable $answered_at): static
    {
        $this->answered_at = $answered_at;

        return $this;
    }

    public function isAnswered(): ?bool
    {
        return $this->answered;
    }

    public function setAnswered(bool $answered): static
    {
        $this->answered = $answered;

        return $this;
    }
}
