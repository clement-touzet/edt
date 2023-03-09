<?php

namespace App\DataFixtures;
use App\Entity\Professeur;
use App\Entity\Matiere;
use App\Entity\Avis;
use App\Entity\Salle;
use App\Entity\Cours;
use App\Entity\NoteCours;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //PROFS
        $prof1 = new Professeur();
        $prof1->setNom('BRUYERE');
        $prof1->setPrenom('Marie');
        $prof1->setEmail('marie@example.com');
        $manager->persist($prof1);

        $prof2 = new Professeur();
        $prof2->setNom('ETCHEVERRY');	
        $prof2->setPrenom('Patrick');
        $prof2->setEmail('patrick.etcheverr@example.com');
        $manager->persist($prof2);

        $prof3 = new Professeur();
        $prof3->setNom('CARPENTIER');
        $prof3->setPrenom('Yann');
        $prof3->setEmail('yann@example.com');
        $manager->persist($prof3);

        $prof4 = new Professeur();
        $prof4->setNom('DEZEQUE');
        $prof4->setPrenom('Olivier');
        $prof4->setEmail('olivier@example.com');
        $manager->persist($prof4);

        $prof5 = new Professeur();
        $prof5->setNom('MARQUESUZAA');
        $prof5->setPrenom('Christophe');
        $prof5->setEmail('christophe@example.com');
        $manager->persist($prof5);

        $prof6 = new Professeur();
        $prof6->setNom('RUSTICCI');
        $prof6->setPrenom('Chiara');
        $prof6->setEmail('chiara@example.com');
        $manager->persist($prof6);

        //MATIERES
        $matiere1 = new Matiere();
        $matiere1->setTitre('Algorithme');
        $matiere1->setReference('I-001');
        $matiere1->addProfesseur($prof2);
        $matiere1->addProfesseur($prof3);
        $manager->persist($matiere1);

        $matiere2 = new Matiere();
        $matiere2->setTitre('Maths discrètes');
        $matiere2->setReference('I-002');
        $matiere2->addProfesseur($prof1);
        $manager->persist($matiere2);

        $matiere3 = new Matiere();
        $matiere3->setTitre('Conception');
        $matiere3->setReference('I-003');
        $matiere3->addProfesseur($prof2);
        $matiere3->addProfesseur($prof3);
        $matiere3->addProfesseur($prof5);
        $manager->persist($matiere3);

        $matiere4 = new Matiere();
        $matiere4->setTitre('Programmation web');
        $matiere4->setReference('I-004');
        $matiere4->addProfesseur($prof3);
        $manager->persist($matiere4);

        $matiere5 = new Matiere();
        $matiere5->setTitre('Communication');
        $matiere5->setReference('C-001');
        $matiere5->addProfesseur($prof4);
        $matiere5->addProfesseur($prof6);
        $manager->persist($matiere5);

        $matiere6 = new Matiere();
        $matiere6->setTitre('Gestion de projet');
        $matiere6->setReference('C-002');
        $matiere6->addProfesseur($prof5);
        $matiere6->addProfesseur($prof6);
        $manager->persist($matiere6);

        $matiere7 = new Matiere();
        $matiere7->setTitre('Programmation avancée');
        $matiere7->setReference('I-005');
        $matiere7->addProfesseur($prof2);
        $matiere7->addProfesseur($prof3);
        $manager->persist($matiere7);

        //AVIS PROFS
        $avis1 = new Avis();
        $avis1->setNote(4);
        $avis1->setCommentaire("La prof est cool");
        $avis1->setEmailEtudiant("guillaume@gmail.com");
        $avis1->setProfesseur($prof1);
        $manager->persist($avis1);

        $avis2 = new Avis();
        $avis2->setNote(5);
        $avis2->setCommentaire("Prof excellent");
        $avis2->setEmailEtudiant("mattheo@gmail.com");
        $avis2->setProfesseur($prof2);
        $manager->persist($avis2);

        $avis3 = new Avis();
        $avis3->setNote(3);
        $avis3->setCommentaire("Prof cool mais j'ai pas compris le tri à bulle");
        $avis3->setEmailEtudiant("guillaume@gmail.com");
        $avis3->setProfesseur($prof2);
        $manager->persist($avis3);

        $avis4 = new Avis();
        $avis4->setNote(5);
        $avis4->setCommentaire("Prof très sympa, bonne ambiance");
        $avis4->setEmailEtudiant("mattheo@gmail.com");
        $avis4->setProfesseur($prof4);
        $manager->persist($avis4);

        $avis5 = new Avis();
        $avis5->setNote(4);
        $avis5->setCommentaire("Le prof est top");
        $avis5->setEmailEtudiant("mattheo@gmail.com");
        $avis5->setProfesseur($prof4);
        $manager->persist($avis5);


        //SALLES
        $salle1 = new Salle();
        $salle1->setNumero(1);
        $manager->persist($salle1);

        $salle2 = new Salle();
        $salle2->setNumero(20);
        $manager->persist($salle2);

        $salle3 = new Salle();
        $salle3->setNumero(125);
        $manager->persist($salle3);

        $salle4 = new Salle();
        $salle4->setNumero(25);
        $manager->persist($salle4);

        $salle5 = new Salle();
        $salle5->setNumero(42);
        $manager->persist($salle5);

        //COURS
        $cours1 = new Cours();
        $cours1->setMatiere($matiere5);
        $cours1->setProfesseur($prof4);
        $cours1->setSalle($salle1);
        $cours1->setDateHeureDebut(new DateTime('2023-03-09 10:00'));
        $cours1->setDateHeureFin(new DateTime('2023-03-09 12:00'));
        $cours1->setType("TD");
        $manager->persist($cours1);

        $cours2 = new Cours();
        $cours2->setMatiere($matiere7);
        $cours2->setProfesseur($prof3);
        $cours2->setSalle($salle2);
        $cours2->setDateHeureDebut(new DateTime('2023-03-09 10:00'));
        $cours2->setDateHeureFin(new DateTime('2023-03-09 12:00'));
        $cours2->setType("Cours");
        $manager->persist($cours2);

        $cours3 = new Cours();
        $cours3->setMatiere($matiere7);
        $cours3->setProfesseur($prof3);
        $cours3->setSalle($salle2);
        $cours3->setDateHeureDebut(new DateTime('2023-03-09 14:00'));
        $cours3->setDateHeureFin(new DateTime('2023-03-09 17:00'));
        $cours3->setType("TD");
        $manager->persist($cours3);

        $cours4 = new Cours();
        $cours4->setMatiere($matiere2);
        $cours4->setProfesseur($prof1);
        $cours4->setSalle($salle3);
        $cours4->setDateHeureDebut(new DateTime('2023-03-10 14:00'));
        $cours4->setDateHeureFin(new DateTime('2023-03-10 17:00'));
        $cours4->setType("TD");
        $manager->persist($cours4);

        $cours5 = new Cours();
        $cours5->setMatiere($matiere2);
        $cours5->setProfesseur($prof1);
        $cours5->setSalle($salle3);
        $cours5->setDateHeureDebut(new DateTime('2023-03-13 08:00'));
        $cours5->setDateHeureFin(new DateTime('2023-03-13 10:00'));
        $cours5->setType("TD");
        $manager->persist($cours5);

        $cours6 = new Cours();
        $cours6->setMatiere($matiere2);
        $cours6->setProfesseur($prof1);
        $cours6->setSalle($salle3);
        $cours6->setDateHeureDebut(new DateTime('2023-03-13 14:00'));
        $cours6->setDateHeureFin(new DateTime('2023-03-13 18:00'));
        $cours6->setType("TP");
        $manager->persist($cours6);

        $cours7 = new Cours();
        $cours7->setMatiere($matiere3);
        $cours7->setProfesseur($prof5);
        $cours7->setSalle($salle5);
        $cours7->setDateHeureDebut(new DateTime('2023-03-14 8:00'));
        $cours7->setDateHeureFin(new DateTime('2023-03-14 9:30'));
        $cours7->setType("TP");
        $manager->persist($cours7);

        $cours8 = new Cours();
        $cours8->setMatiere($matiere3);
        $cours8->setProfesseur($prof5);
        $cours8->setSalle($salle5);
        $cours8->setDateHeureDebut(new DateTime('2023-03-14 10:00'));
        $cours8->setDateHeureFin(new DateTime('2023-03-14 12:00'));
        $cours8->setType("TP");
        $manager->persist($cours8);

        $cours9 = new Cours();
        $cours9->setMatiere($matiere1);
        $cours9->setProfesseur($prof3);
        $cours9->setSalle($salle1);
        $cours9->setDateHeureDebut(new DateTime('2023-03-15 14:00'));
        $cours9->setDateHeureFin(new DateTime('2023-03-15 17:00'));
        $cours9->setType("TP");
        $manager->persist($cours9);

        $cours10 = new Cours();
        $cours10->setMatiere($matiere1);
        $cours10->setProfesseur($prof3);
        $cours10->setSalle($salle1);
        $cours10->setDateHeureDebut(new DateTime('2023-03-16 10:00'));
        $cours10->setDateHeureFin(new DateTime('2023-03-16 12:00'));
        $cours10->setType("Cours");
        $manager->persist($cours10);

        $cours10 = new Cours();
        $cours10->setMatiere($matiere1);
        $cours10->setProfesseur($prof3);
        $cours10->setSalle($salle1);
        $cours10->setDateHeureDebut(new DateTime('2023-03-16 15:00'));
        $cours10->setDateHeureFin(new DateTime('2023-03-16 17:00'));
        $cours10->setType("TP");
        $manager->persist($cours10);

        $cours11 = new Cours();
        $cours11->setMatiere($matiere6);
        $cours11->setProfesseur($prof5);
        $cours11->setSalle($salle1);
        $cours11->setDateHeureDebut(new DateTime('2023-03-17 09:00'));
        $cours11->setDateHeureFin(new DateTime('2023-03-17 12:00'));
        $cours11->setType("TP");
        $manager->persist($cours11);


        //NOTES COURS
        $noteCours1 = new NoteCours();
        $noteCours1->setCours($cours5);
        $noteCours1->setNote(3);
        $noteCours1->setCommentaire("Bon cours mais j'ai pas tout compris");
        $noteCours1->setEmailEtudiant("clement@example.com");
        $manager->persist($noteCours1);

        $noteCours2 = new NoteCours();
        $noteCours2->setCours($cours6);
        $noteCours2->setNote(2);
        $noteCours2->setCommentaire("J'ai pas trop aimé l'algo de dijkstra sur python en fait");
        $noteCours2->setEmailEtudiant("guillaume@example.com");
        $manager->persist($noteCours2);

        $noteCours3 = new NoteCours();
        $noteCours3->setCours($cours7);
        $noteCours3->setNote(1);
        $noteCours3->setCommentaire("Cours à sensation fortes surtout quand on connaît pas son cours");
        $noteCours3->setEmailEtudiant("alexandre@example.com");
        $manager->persist($noteCours3);

        $noteCours4 = new NoteCours();
        $noteCours4->setCours($cours8);
        $noteCours4->setNote(1);
        $noteCours4->setCommentaire("Je me suis fait virer du cours parce que j'avais pas de demi-feuille");
        $noteCours4->setEmailEtudiant("alexandre@example.com");
        $manager->persist($noteCours4);

        $noteCours5 = new NoteCours();
        $noteCours5->setCours($cours8);
        $noteCours5->setNote(4);
        $noteCours5->setCommentaire("Le prof fait peur mais ça va en fait");
        $noteCours5->setEmailEtudiant("mathou@example.com");
        $manager->persist($noteCours5);

        $noteCours6 = new NoteCours();
        $noteCours6->setCours($cours9);
        $noteCours6->setNote(4);
        $noteCours6->setCommentaire("Très bon cours, le prof est pédadogue");
        $noteCours6->setEmailEtudiant("mathou@example.com");
        $manager->persist($noteCours6);

        $noteCours7 = new NoteCours();
        $noteCours7->setCours($cours9);
        $noteCours7->setNote(4);
        $noteCours7->setCommentaire("Top");
        $noteCours7->setEmailEtudiant("clement@example.com");
        $manager->persist($noteCours7);

        $noteCours8 = new NoteCours();
        $noteCours8->setCours($cours10);
        $noteCours8->setNote(5);
        $noteCours8->setCommentaire("Le cours est très clair c'est impeccable, le prof est dispo pour les étudiants");
        $noteCours8->setEmailEtudiant("florian@example.com");
        $manager->persist($noteCours8);

        $noteCours9 = new NoteCours();
        $noteCours9->setCours($cours11);
        $noteCours9->setNote(5);
        $noteCours9->setCommentaire("Bon cours de gestion de projet");
        $noteCours9->setEmailEtudiant("mathou@example.com");
        $manager->persist($noteCours9);

        $manager->flush();
    }
}
?>