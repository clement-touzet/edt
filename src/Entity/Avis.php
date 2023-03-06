<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[UniqueEntity(fields: ['professeur', 'emailEtudiant'], errorPath: 'emailEtudiant', message: 'Cet étudiant à déjà noté ce professeur.')]
class Avis implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\Range(min: 0, max: 5)]
    private ?int $note = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $commentaire = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    private ?string $emailEtudiant = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professeur $professeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getEmailEtudiant(): ?string
    {
        return $this->emailEtudiant;
    }

    public function setEmailEtudiant(string $emailEtudiant): self
    {
        $this->emailEtudiant = $emailEtudiant;

        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s %s (%s)', $this->note, $this->commentaire, $this->emailEtudiant);
    }

    function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'note' => $this->getNote(),
            'commentaire' => $this->getCommentaire(),
            'emailEtudiant' => $this->getEmailEtudiant()
        ];
    }

    public function fromArray(array $data): self
    {
        $this->note = $data['note'] ?? $this->note;
        $this->commentaire = $data['commentaire'] ?? $this->commentaire;
        $this->emailEtudiant = $data['emailEtudiant'] ?? $this->emailEtudiant;

        return $this;
    }
}
