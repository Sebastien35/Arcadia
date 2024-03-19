<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\Util\Json as UtilJson;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['info_animal'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['info_animal'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: CommentaireHabitat::class)]
    private Collection $commentaireHabitats;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: InfoAnimal::class)]
    private Collection $infoAnimals;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this User.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every User at least has ROLE_USER
        $roles[] = 'ROLE_EMPLOYE';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the User, clear it here
        // $this->plainPassword = null;
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


    public function __construct(string $email, string $password, array $roles, \DateTimeImmutable $createdAt, ?\DateTimeImmutable $updatedAt,)
    {
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->commentaireHabitats = new ArrayCollection();
        $this->infoAnimals = new ArrayCollection();
        
        
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
            $commentaireHabitat->setAuteur($this);
        }

        return $this;
    }

    public function removeCommentaireHabitat(CommentaireHabitat $commentaireHabitat): static
    {
        if ($this->commentaireHabitats->removeElement($commentaireHabitat)) {
            // set the owning side to null (unless already changed)
            if ($commentaireHabitat->getAuteur() === $this) {
                $commentaireHabitat->setAuteur(null);
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
            $infoAnimal->setAuteur($this);
        }

        return $this;
    }

    public function removeInfoAnimal(InfoAnimal $infoAnimal): static
    {
        if ($this->infoAnimals->removeElement($infoAnimal)) {
            // set the owning side to null (unless already changed)
            if ($infoAnimal->getAuteur() === $this) {
                $infoAnimal->setAuteur(null);
            }
        }

        return $this;
    }
}