<?php

namespace App\Entity;

use App\Repository\TicketBeneficiairyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketBeneficiairyRepository::class)
 */
class TicketBeneficiairy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Ticket::class, inversedBy="beneficiairy")
     */
    private $ticket;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="beneficiairy")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
