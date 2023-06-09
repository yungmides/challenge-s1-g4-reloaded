<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DemandesRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DemandesRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['demandes:read']],
    denormalizationContext: ['groups' => ['demandes:write']],
    operations: [
        new Get(
            security: 'is_granted("ROLE_ADMIN")',
            securityMessage: 'Only admins can get the demandes'
        ),
        new GetCollection(
            security: 'is_granted("ROLE_ADMIN")',
            securityMessage: 'Only admins can get the demandes'
        ),
        new Post(
            security: 'is_granted("ROLE_USER") || is_granted("ROLE_VENDEUR") || is_granted("ROLE_ANNONCEUR")',
            securityMessage: 'Only authenticated users can create the demandes'
        ),
        new Put(
            security: 'is_granted("ROLE_ADMIN")',
            securityMessage: 'Only admins can update the demandes'
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN")',
            securityMessage: 'Only admins and the current user can delete the demandes'
        )
    ]
)]
class Demandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['demandes:read'])]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'demandes')]
    private ?User $owner = null;

    #[Groups(['demandes:read', 'demandes:write'])]
    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[Groups(['demandes:read', 'demandes:write'])]
    #[ORM\Column(length: 300, nullable: true)]
    private ?string $message = null;

    #[Groups(['demandes:read', 'demandes:write'])]
    #[ORM\Column]
    private ?string $tel = null;

    #[Groups(['demandes:read', 'demandes:write'])]
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[Groups(['demandes:read', 'demandes:write'])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Groups(['demandes:read', 'demandes:write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $entrepriseName = null;

    #[Groups(['demandes:read', 'demandes:write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $entrepriseLink = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEntrepriseName(): ?string
    {
        return $this->entrepriseName;
    }

    public function setEntrepriseName(?string $entrepriseName): self
    {
        $this->entrepriseName = $entrepriseName;

        return $this;
    }

    public function getEntrepriseLink(): ?string
    {
        return $this->entrepriseLink;
    }

    public function setEntrepriseLink(?string $entrepriseLink): self
    {
        $this->entrepriseLink = $entrepriseLink;

        return $this;
    }

}
