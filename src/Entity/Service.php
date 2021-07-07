<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="service")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="support_assign")
     */
    private $tickets_assign;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->tickets_assign = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setService($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getService() === $this) {
                $user->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTicketsAssign(): Collection
    {
        return $this->tickets_assign;
    }

    public function addTicketsAssign(Ticket $ticketsAssign): self
    {
        if (!$this->tickets_assign->contains($ticketsAssign)) {
            $this->tickets_assign[] = $ticketsAssign;
            $ticketsAssign->setSupportAssign($this);
        }

        return $this;
    }

    public function removeTicketsAssign(Ticket $ticketsAssign): self
    {
        if ($this->tickets_assign->removeElement($ticketsAssign)) {
            // set the owning side to null (unless already changed)
            if ($ticketsAssign->getSupportAssign() === $this) {
                $ticketsAssign->setSupportAssign(null);
            }
        }

        return $this;
    }
}
