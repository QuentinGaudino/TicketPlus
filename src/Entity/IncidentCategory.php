<?php

namespace App\Entity;

use App\Repository\IncidentCategoryRepository;
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
}
