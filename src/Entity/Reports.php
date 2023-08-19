<?php

namespace App\Entity;

use App\Repository\ReportsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportsRepository::class)]
class Reports
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hours = null;

    #[ORM\Column(nullable: true)]
    private ?int $publications = null;

    #[ORM\Column(nullable: true)]
    private ?int $videos = null;

    #[ORM\Column(nullable: true)]
    private ?int $nv_visites = null;

    #[ORM\Column(nullable: true)]
    private ?int $studies = null;

    #[ORM\Column(length: 255)]
    private ?string $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHours(): ?\DateTimeInterface
    {
        return $this->hours;
    }

    public function setHours(\DateTimeInterface $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getPublications(): ?int
    {
        return $this->publications;
    }

    public function setPublications(?int $publications): self
    {
        $this->publications = $publications;

        return $this;
    }

    public function getVideos(): ?int
    {
        return $this->videos;
    }

    public function setVideos(?int $videos): self
    {
        $this->videos = $videos;

        return $this;
    }

    public function getNvVisites(): ?int
    {
        return $this->nv_visites;
    }

    public function setNvVisites(?int $nv_visites): self
    {
        $this->nv_visites = $nv_visites;

        return $this;
    }

    public function getStudies(): ?int
    {
        return $this->studies;
    }

    public function setStudies(?int $studies): self
    {
        $this->studies = $studies;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }
}
