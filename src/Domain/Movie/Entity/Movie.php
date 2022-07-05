<?php

namespace App\Domain\Movie\Entity;

use App\Domain\User\Entity\User;
use App\Repository\MovieRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\Table(name: '`movie`')]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Cast::class, cascade: ["PERSIST"])]
    private Collection $casts;

    #[ORM\Column(type: 'date')]
    private ?DateTimeInterface $releaseDate = null;

    #[ORM\Column(type: 'string')]
    private ?string $director = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Rating::class, cascade: ["PERSIST"])]
    private Collection $ratings;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id', nullable: false)]
    private ?User $owner = null;

    public function __construct()
    {
        $this->casts = new ArrayCollection();
        $this->ratings = new ArrayCollection();
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

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): self
    {
        $this->director = $director;

        return $this;
    }

    /**
     * @return Collection<int, Cast>
     */
    public function getCasts(): Collection
    {
        return $this->casts;
    }

    public function addCast(Cast $cast): self
    {
        if (!$this->casts->contains($cast)) {
            $this->casts[] = $cast;
            $cast->setMovie($this);
        }

        return $this;
    }

    public function removeCast(Cast $cast): self
    {
        if ($this->casts->removeElement($cast)) {
            // set the owning side to null (unless already changed)
            if ($cast->getMovie() === $this) {
                $cast->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setMovie($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getMovie() === $this) {
                $rating->setMovie(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
