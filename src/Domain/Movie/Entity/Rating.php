<?php

namespace App\Domain\Movie\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: '`movie_rating`')]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private ?string $platformName = null;

    #[ORM\Column(type: 'float')]
    private ?float $rate = null;

    #[ORM\ManyToOne(targetEntity: Movie::class)]
    #[ORM\JoinColumn(name: 'movie_id', referencedColumnName: 'id', nullable: false)]
    private ?Movie $movie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlatformName(): ?string
    {
        return $this->platformName;
    }

    public function setPlatformName(string $platformName): self
    {
        $this->platformName = $platformName;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }
}
