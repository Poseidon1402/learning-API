<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Valid;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'read:collections'],
    denormalizationContext: ['groups' => 'write:Post'],
    collectionOperations: [
        'get',
        'post' => [
            'validation_groups' => ['create:post']
        ]
    ],
    itemOperations: [
        'put' => [
            'denormalization_context' => ['groups' => 'put:item']
        ],
        'get' => [
            'normalization_context' => ['groups' => ['read:item', 'read:Post']]
        ]
    ]
)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:collections', 'read:item'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[
        Groups(['read:collections', 'read:item', 'put:item', 'write:Post']),
        Length(
            min: 6, minMessage: "The length of the title should be at least 6 characters",
            max: 25, maxMessage: "The title should be less or equal than 25 characters",
            groups: ['create:post']
        )
    ]
    private $title;

    #[ORM\Column(type: 'text')]
    #[Groups(['read:item', 'put:item', 'write:Post'])]
    private $content;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'posts', cascade: ['persist'])]
    #[
        Groups(['read:item', 'write:Post', 'put:item']),
        Valid()
    ]
    private $Category;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable;
        $this->updatedAt = new DateTimeImmutable;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }
}
