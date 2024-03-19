<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(collection: "animal_visits")]
class AnimalVisit
{
    #[MongoDB\Id]
    protected ?string $id;

    #[MongoDB\Field(type: "integer")]
    protected ?int $animalId;

    #[MongoDB\Field(type: "integer")]
    protected ?int $visits = 0;

    #[MongoDB\Field(type: "string")]
    protected ?string $animal_name;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAnimalId(): ?int
    {
        return $this->animalId;
    }

    public function setAnimalId(int $animalId): self
    {
        $this->animalId = $animalId;

        return $this;
    }

    public function getVisits(): ?int
    {
        return $this->visits;
    }

    public function incrementVisits(): self
    {
        $this->visits++;

        return $this;
    }

    public function getAnimalName(): ?string
    {
        return $this->animal_name;
    }

    public function setAnimalName(string $animal_name): self
    {
        $this->animal_name = $animal_name;

        return $this;
    }

}