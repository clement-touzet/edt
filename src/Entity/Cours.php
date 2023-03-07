<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours implements \JSONSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type("\DateTimeInterface")]
    //TODO: essayer de faire en sorte qu'un cours ne puisse pas être programmé sur deux jours différents et qu'il respecte les horaires 8h-18h
    //Problème rencontré: la fonction Range sur une date ne récupère que la date du jour donc on ne peut pas programmer dans le futur


    // #[Assert\Range(min: "8am", max: "5pm", notInRangeMessage:"Les cours commencent à min: 8h et max: 17h")]
    // #[Assert\Range(min: '8am',max: '+9 hours')]
    private ?\DateTimeInterface $dateHeureDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\GreaterThan(propertyPath:"dateHeureDebut", message:"La date de fin ne peut pas être inférieure à la date de début")]

    //TODO: essayer de faire en sorte qu'un cours ne puisse pas être programmé sur deux jours différents et qu'il respecte les horaires 8h-18h
    //Problème rencontré: la fonction Range sur une date ne récupère que la date du jour donc on ne peut pas programmer dans le futur

    // #[Assert\Range(min: "9am", max: "6pm", notInRangeMessage:"Les cours finissent à min: 9h et max: 18h")]
    // #[Assert\Range(min: '9am',max: '+9 hours', notInRangeMessage:"Les cours ne peuvent pas être sur plusieurs jours")]

    private ?\DateTimeInterface $dateHeureFin = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(['TD','TP','Cours'])]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Professeur $professeur = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Salle $salle = null;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: NoteCours::class)]
    private Collection $noteCours;

    public function __construct()
    {
        $this->noteCours = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf('%s - %s - %s', $this->getType(), $this->getMatiere(), $this->getProfesseur());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDateHeureFin(): ?\DateTimeInterface
    {
        return $this->dateHeureFin;
    }

    public function setDateHeureFin(\DateTimeInterface $dateHeureFin): self
    {
        $this->dateHeureFin = $dateHeureFin;

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

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

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

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'dateHeureDebut' => $this->getDateHeureDebut(),
            'dateHeureFin' => $this->getDateHeureFin(),
            'type' => $this->getType(),
            'matiere' => $this->getMatiere(),
            'professeur' => $this->getProfesseur(),
            'salle' => $this->getSalle(),
        ];
    }

    /**
     * @return Collection<int, NoteCours>
     */
    public function getNoteCours(): Collection
    {
        return $this->noteCours;
    }

    public function addNoteCour(NoteCours $noteCour): self
    {
        if (!$this->noteCours->contains($noteCour)) {
            $this->noteCours->add($noteCour);
            $noteCour->setCours($this);
        }

        return $this;
    }

    public function removeNoteCour(NoteCours $noteCour): self
    {
        if ($this->noteCours->removeElement($noteCour)) {
            // set the owning side to null (unless already changed)
            if ($noteCour->getCours() === $this) {
                $noteCour->setCours(null);
            }
        }

        return $this;
    }
}
?>