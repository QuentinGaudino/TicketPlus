<?php

namespace App\Entity;

use App\Repository\DemandCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandCategoryRepository::class)
 */
class DemandCategory
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
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=DemandCategory::class, inversedBy="parentName")
     */
    private $parentName;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="demandCategory")
     */
    private $tickets;

    public function __construct()
    {
        $this->parentName = new ArrayCollection();
        $this->tickets = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getParentName(): ?self
    {
        return $this->parentName;
    }

    public function setParentName(?self $parentName): self
    {
        $this->parentName = $parentName;

        return $this;
    }

    public function addParentName(self $parentName): self
    {
        if (!$this->parentName->contains($parentName)) {
            $this->parentName[] = $parentName;
            $parentName->setParentName($this);
        }

        return $this;
    }

    public function removeParentName(self $parentName): self
    {
        if ($this->parentName->removeElement($parentName)) {
            // set the owning side to null (unless already changed)
            if ($parentName->getParentName() === $this) {
                $parentName->setParentName(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setDemandCategory($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getDemandCategory() === $this) {
                $ticket->setDemandCategory(null);
            }
        }

        return $this;
    }
}
