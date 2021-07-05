<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatarLink;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="users")
     */
    private $service;

    /**
     * @ORM\ManyToMany(targetEntity=UserCategory::class, inversedBy="users")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=TicketBeneficiairy::class, mappedBy="user")
     */
    private $beneficiairy;

    /**
     * @ORM\OneToMany(targetEntity=TicketMessage::class, mappedBy="user")
     */
    private $message;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->beneficiairy = new ArrayCollection();
        $this->message = new ArrayCollection();
    }

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAvatarLink(): ?string
    {
        return $this->avatarLink;
    }

    public function setAvatarLink(?string $avatarLink): self
    {
        $this->avatarLink = $avatarLink;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection|UserCategory[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(UserCategory $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(UserCategory $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|TicketBeneficiairy[]
     */
    public function getBeneficiairy(): Collection
    {
        return $this->beneficiairy;
    }

    public function addBeneficiairy(TicketBeneficiairy $beneficiairy): self
    {
        if (!$this->beneficiairy->contains($beneficiairy)) {
            $this->beneficiairy[] = $beneficiairy;
            $beneficiairy->setUser($this);
        }

        return $this;
    }

    public function removeBeneficiairy(TicketBeneficiairy $beneficiairy): self
    {
        if ($this->beneficiairy->removeElement($beneficiairy)) {
            // set the owning side to null (unless already changed)
            if ($beneficiairy->getUser() === $this) {
                $beneficiairy->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TicketMessage[]
     */
    public function getMessage(): Collection
    {
        return $this->message;
    }

    public function addMessage(TicketMessage $message): self
    {
        if (!$this->message->contains($message)) {
            $this->message[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(TicketMessage $message): self
    {
        if ($this->message->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }
}
