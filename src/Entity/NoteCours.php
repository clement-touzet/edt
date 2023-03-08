<?php

namespace App\Entity;

use App\Repository\NoteCoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



#[ORM\Entity(repositoryClass: NoteCoursRepository::class)]
#[UniqueEntity(fields: ['cours', 'emailEtudiant'], errorPath: 'emailEtudiant', message: 'Cet étudiant à déjà noté ce cours.')]
class NoteCours implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\Range(min: 0, max: 5)]
    private ?int $note = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaire = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    private ?string $emailEtudiant = null;

    #[ORM\ManyToOne(inversedBy: 'noteCours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $cours = null;

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'note' => $this->getNote(),
            'commentaire' => $this->getCommentaire(),
            'emailEtudiant' => $this->getEmailEtudiant()
        ];
    }

    public function fromArray($data): self
    {
        $this->note = $data['note'] ?? $this->note;
        $this->commentaire = $data['commentaire'] ?? $this->commentaire;
        $this->emailEtudiant = $data['emailEtudiant'] ?? $this->emailEtudiant;
        return $this;
    }

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

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
}
