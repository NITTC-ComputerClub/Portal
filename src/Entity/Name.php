<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\NameRepository")
 */
class Name
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstNameKana;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastNameKana;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="name", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstNameKana(): ?string
    {
        return $this->firstNameKana;
    }

    public function setFirstNameKana(string $firstNameKana): self
    {
        $this->firstNameKana = $firstNameKana;

        return $this;
    }

    public function getLastNameKana(): ?string
    {
        return $this->lastNameKana;
    }

    public function setLastNameKana(string $lastNameKana): self
    {
        $this->lastNameKana = $lastNameKana;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        // set the owning side of the relation if necessary
        if ($this !== $user->getName()) {
            $user->setName($this);
        }

        return $this;
    }
}
