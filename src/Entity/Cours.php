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
    #[Assert\Expression('this.pauseDej() == true', message: '')]
    #[Assert\Expression('this.verifDateHeureDebut() == true', message: 'Les cours commencent à partir de 8h')]
    private ?\DateTimeInterface $dateHeureDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\GreaterThan(propertyPath: "dateHeureDebut", message: "La date de fin ne peut pas être inférieure à la date de début")]
    #[Assert\Expression('this.pauseDej() == true', message: 'Attention, les cours ne peuvent pas empiéter sur la pause du midi')]
    #[Assert\Expression('this.dureeCoursValide() == true', message: 'La durée du cours est trop longue')]
    #[Assert\Expression('this.verifDateHeureFin() == true', message: 'Les cours finissent à 18h')]
    private ?\DateTimeInterface $dateHeureFin = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Expression('this.verifMatiereProfesseur()==true', message: 'Vous ne pouvez pas attribuer un professeur à un cours dont il n\'enseigne pas la matière')]
    private ?Professeur $professeur = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Salle $salle = null;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: NoteCours::class, orphanRemoval: true)]
    private Collection $noteCours;


    /* METHODES CUSTOM POUR ASSERT */

    /* verifDateHeureFin sert à vérifier que les cours se terminent bien à 18h et pas après */
    public function verifDateHeureFin(): bool
    {
        return (\DateTime::createFromFormat('Y-m-d H-i-s', $this->getDateHeureFin()->format('Y-m-d H-i-s'))
            ->diff((\DateTime::createFromFormat('Y-m-d H-i-s', $this->getDateHeureFin()->format('Y-m-d H-i-s')))
                ->setTime(0, 0, 0)))->h > 18 ? false : true;
    }

    /* verifDateHeureDebut sert à vérifier que les cours commencent à partir de 8h */
    public function verifDateHeureDebut(): bool
    {
        return (\DateTime::createFromFormat('Y-m-d H-i-s', $this->getDateHeureDebut()->format('Y-m-d H-i-s'))
            ->diff((\DateTime::createFromFormat('Y-m-d H-i-s', $this->getDateHeureDebut()->format('Y-m-d H-i-s')))
                ->setTime(0, 0, 0)))->h < 8 ? false : true;
    }

    /* verifMatiereProfesseur vérifie que le professeur assigné au cours est bien prof dans la matière du cours */
    public function verifMatiereProfesseur(): bool
    {
        foreach ($this->getProfesseur()->getMatieres() as $matiere) {
            if ($matiere->getTitre() == $this->getMatiere()->getTitre()) {
                return true;
            }
        };
        return false;
    }

    /* pauseDej qui vérifie que les cours ne sont pas programmés pendant la pause déjeuner  */
    public function pauseDej(): bool
    {
        //$intervalDeb et fin c'est l'heure du cours (qu'on a choisit) -> en date yyyy-mm-dd-h-i-s
        $intervalDebut = \DateTime::createFromFormat('Y-m-d H:i:s', $this->getDateHeureDebut()->format('Y-m-d H:i:s'))
            ->diff((\DateTime::createFromFormat('Y-m-d H:i:s', $this->getDateHeureDebut()->format('Y-m-d H:i:s'))->setTime(0, 0, 0)));

        $intervalFin = \DateTime::createFromFormat('Y-m-d H:i:s', $this->getDateHeureFin()->format('Y-m-d H:i:s'))
            ->diff((\DateTime::createFromFormat('Y-m-d H:i:s', $this->getDateHeureFin()->format('Y-m-d H:i:s'))->setTime(0, 0, 0)));

        //dureeDeb et fin <=> l'heure du cours en minute
        $dureeDebut = $intervalDebut->h * 60 + $intervalDebut->i;
        $dureeFin = $intervalFin->h * 60 + $intervalFin->i;

        //750 -> 12h30, 840 -> 14h
        //on vérifie que le cours commence pas pdt pause et si il commence avant, on vérifie qu'il finie pas pendant ou après
        //on peut pas créer un cours qui comment à 11h59 et finir 14h01
        return ($dureeDebut < 750 && $dureeFin > 750) || ($dureeDebut > 750 && $dureeFin < 840) ? false : true;
    }

    /* dureeCoursValide sert à vérifier que la durée qu'un cours soit valide. Elle sert à éviter qu'on puisse programmer un cours d'un jour
        à l'autre 
        - fonctionnement similaire au pauseDej*/
    public function dureeCoursValide(): bool
    {
        $interval = \DateTime::createFromFormat('Y-m-d H:i:s', $this->getDateHeureDebut()->format('Y-m-d H:i:s'))
            ->diff(\DateTime::createFromFormat('Y-m-d H:i:s', $this->getDateHeureFin()->format('Y-m-d H:i:s')));
        $length = $interval->i + $interval->h * 60 + $interval->d * 24 * 60;

        //on vérifie que la durée d'un cours ne dépasse pas 5 heures
        return $length > 300 ? false : true;
    }

    /* FIN METHODES CUSTOM */

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
            'notes' => $this->getNoteCours()->toArray()
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
