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

    // #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?Zoo $id_etablissement = null;

    #[ORM\Column(type: Types::STRING, length: 8)]
    private ?string $jour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $h_ouverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $h_fermeture = null;

    #[ORM\Column]
    private ?bool $ouvert = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getIdEtablissement(): ?Zoo
    //{
    //    return $this->id_etablissement;
    //}

     //public function setIdEtablissement(Zoo $id_etablissement): static
     //{
     //    $this->id_etablissement = $id_etablissement;
      //   
       // return $this;
     //}

    
    public function getJour(): ?string
    {
        return $this->jour;
    }
    public function setJour(string $jour): static
    {
        $this->jour = $jour;

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

    public function __construct(
        
        ?int $jour = null,
        ?bool $ouvert = true,
        ?\DateTimeInterface $h_ouverture = null,
        ?\DateTimeInterface $h_fermeture = null
    ) {
         // $this->id_etablissement = $id_etablissement;
        
        $this->$jour = $jour;
        $this->ouvert = $ouvert;
        $this->h_ouverture = $h_ouverture;
        $this->h_fermeture = $h_fermeture;
    }

    public function isOuvert(): ?bool
    {
        return $this->ouvert;
    }

    public function setOuvert(bool $ouvert): static
    {
        $this->ouvert = $ouvert;

        return $this;
    }
    
}
