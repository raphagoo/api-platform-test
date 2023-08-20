<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $isbn = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Review::class, orphanRemoval: true)]
    private Collection $Reviews;

    public function __construct()
    {
        $this->Reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->Reviews;
    }

    public function addReview(Review $Review): static
    {
        if (!$this->Reviews->contains($Review)) {
            $this->Reviews->add($Review);
            $Review->setBook($this);
        }

        return $this;
    }

    public function removeReview(Review $Review): static
    {
        if ($this->Reviews->removeElement($Review)) {
            // set the owning side to null (unless already changed)
            if ($Review->getBook() === $this) {
                $Review->setBook(null);
            }
        }

        return $this;
    }
}
