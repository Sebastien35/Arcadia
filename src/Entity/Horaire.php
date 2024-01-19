<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRepository::class)]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?zoo $id_etablissement = null;

    #[ORM\Column]
    private ?int $id_jour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $h_ouverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $h_fermeture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEtablissement(): ?zoo
    {
        return $this->id_etablissement;
    }

    public function setIdEtablissement(zoo $id_etablissement): static
    {
        $this->id_etablissement = $id_etablissement;

        return $this;
    }

    public function getIdJour(): ?int
    {
        return $this->id_jour;
    }

    public function setIdJour(int $id_jour): static
    {
        $this->id_jour = $id_jour;

        return $this;
    }

    public function getHOuverture(): ?\DateTimeInterface
    {
        return $this->h_ouverture;
    }

    public function setHOuverture(\DateTimeInterface $h_ouverture): static
    {
        $this->h_ouverture = $h_ouverture;

        return $this;
    }

    public function getHFermeture(): ?\DateTimeInterface
    {
        return $this->h_fermeture;
    }

    public function setHFermeture(\DateTimeInterface $h_fermeture): static
    {
        $this->h_fermeture = $h_fermeture;

        return $this;
    }
}
