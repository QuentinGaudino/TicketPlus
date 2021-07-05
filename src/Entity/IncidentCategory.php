<?php

namespace App\Entity;

use App\Repository\IncidentCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IncidentCategoryRepository::class)
 */
class IncidentCategory
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
     * @ORM\ManyToOne(targetEntity=Incidentcategory::class, inversedBy="parentName")
     */
    private $parentName;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="incidentCategory")
     */
    private $incidentCategory;

    public function __construct()
    {
        $this->incidentCategory = new ArrayCollection();
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

    public function getParentName(): ?Incidentcategory
    {
        return $this->parentName;
    }

    public function setParentName(?Incidentcategory $parentName): self
    {
        $this->parentName = $parentName;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getIncidentCategory(): Collection
    {
        return $this->incidentCategory;
    }

    public function addincidentCategory(Ticket $incidentCategory): self
    {
        if (!$this->incidentCategory->contains($incidentCategory)) {
            $this->incidentCategory[] = $incidentCategory;
            $incidentCategory->setIncidentCategory($this);
        }

        return $this;
    }

    public function removeincidentCategory(Ticket $incidentCategory): self
    {
        if ($this->incidentCategory->removeElement($incidentCategory)) {
            // set the owning side to null (unless already changed)
            if ($incidentCategory->getIncidentCategory() === $this) {
                $incidentCategory->setIncidentCategory(null);
            }
        }

        return $this;
    }
}
