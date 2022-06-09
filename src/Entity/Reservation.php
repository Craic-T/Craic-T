<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date;

    #[ORM\OneToOne(inversedBy: 'reservation', targetEntity: user::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $client;

    #[ORM\ManyToOne(targetEntity: Prestation::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private $Prestation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?user
    {
        return $this->client;
    }

    public function setClient(user $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPrestation(): ?Prestation
    {
        return $this->Prestation;
    }

    public function setPrestation(?Prestation $Prestation): self
    {
        $this->Prestation = $Prestation;

        return $this;
    }
}
