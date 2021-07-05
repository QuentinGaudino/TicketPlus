<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
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
    private $Name;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="date")
     */
    private $Creation_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $Incident_date;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="tickets")
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity=TicketBeneficiairy::class, mappedBy="ticket")
     */
    private $beneficiairy;

    /**
     * @ORM\OneToMany(targetEntity=TicketMessage::class, mappedBy="ticket")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=TicketType::class, inversedBy="tickets")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=TicketGravity::class, inversedBy="tickets")
     */
    private $gravity;

    /**
     * @ORM\ManyToOne(targetEntity=TicketStatus::class, inversedBy="tickets")
     */
    private $status;

    public function __construct()
    {
        $this->beneficiairy = new ArrayCollection();
        $this->message = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->Creation_date;
    }

    public function setCreationDate(\DateTimeInterface $Creation_date): self
    {
        $this->Creation_date = $Creation_date;

        return $this;
    }

    public function getIncidentDate(): ?\DateTimeInterface
    {
        return $this->Incident_date;
    }

    public function setIncidentDate(?\DateTimeInterface $Incident_date): self
    {
        $this->Incident_date = $Incident_date;

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
            $beneficiairy->setTicket($this);
        }

        return $this;
    }

    public function removeBeneficiairy(TicketBeneficiairy $beneficiairy): self
    {
        if ($this->beneficiairy->removeElement($beneficiairy)) {
            // set the owning side to null (unless already changed)
            if ($beneficiairy->getTicket() === $this) {
                $beneficiairy->setTicket(null);
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
            $message->setTicket($this);
        }

        return $this;
    }

    public function removeMessage(TicketMessage $message): self
    {
        if ($this->message->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getTicket() === $this) {
                $message->setTicket(null);
            }
        }

        return $this;
    }

    public function getType(): ?TicketType
    {
        return $this->type;
    }

    public function setType(?TicketType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getGravity(): ?TicketGravity
    {
        return $this->gravity;
    }

    public function setGravity(?TicketGravity $gravity): self
    {
        $this->gravity = $gravity;

        return $this;
    }

    public function getStatus(): ?TicketStatus
    {
        return $this->status;
    }

    public function setStatus(?TicketStatus $status): self
    {
        $this->status = $status;

        return $this;
    }
}
