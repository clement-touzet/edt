`CAZENAVE Mathilde - TOUZET Clément`

# Process d'installation du projet

# DEFINITION DES POINTS D'ENTREE DE L'API

# Définition des points d'entrees de l'API

### Cours

Liste de tous les cours:
[/api/cours](http://localhost:8000/api/cours)

```
http://localhost:8000/api/cours
```

Liste des cours pour une date précise: [/api/cours/cours-from-date?annee=AAAA&mois=MM&jour=JJ](http://localhost:8000/api/cours/cours-from-date?annee=2023&mois=03&jour=04)

```
http://localhost:8000/api/cours/cours-from-date?annee=2023&mois=03&jour=04
```

### Salles

Liste des salles
[/api/salles](http://localhost:8000/api/salles)

```
http://localhost:8000/api/salles
```

### Matière

Liste des matières: [/api/matiere](http://localhost:8000/api/matiere)

```
http://localhost:8000/api/matiere
```

Liste des professeurs par matières: [/api/matiere/professeurs](http://localhost:8000/api/matiere/professeurs)

```
http://localhost:8000/api/matiere/professeurs
```

# Validateurs ajoutés

### Cours

dateHeureDebut et dateHeureFin:  
 `#[Assert\Type("\DateTimeInterface")] //pour être sûr qu'on reçoit le bon type de date`
  
dateHeureDebut:
 `#[Assert\Expression('this.pauseDej() == true', message: '')]`
  `#[Assert\Expression('this.verifDateHeureDebut() == true', message: 'Les cours commencent à partir de 8h')]`

dateHeureFin: 
  `#[Assert\GreaterThan(propertyPath: "dateHeureDebut", message: "La date de fin ne peut pas être inférieure à la date de début")]`
  `#[Assert\Expression('this.pauseDej() == true', message: 'Attention, les cours ne peuvent pas empiéter sur la pause du midi')]`
  `#[Assert\Expression('this.dureeCoursValide() == true', message: 'La durée du cours est trop longue')]`
  `#[Assert\Expression('this.verifDateHeureFin() == true', message: 'Les cours finissent à 18h')]`

type:
  `#[Assert\Choice(['TD','TP','Cours'])] //On s'assure que le choix TD, TP ou cours est imposé`

professeur: 
 `    #[Assert\Expression('this.verifMatiereProfesseur()==true', message: 'Vous ne pouvez pas attribuer un professeur à un cours dont il n\'enseigne pas la matière')] `

professeur, salle et matiere: `#[Assert\NotBlank] //Pour être sûr que les champs soient bien remplis`

### Avis

note:
    `#[Assert\Range(min: 0, max: 5)]`

commentaire: 
    `#[Assert\NotBlank]`

emailEtudiant:
    `#[Assert\Email]`    

### NoteCours

note:
    `#[Assert\Range(min: 0, max: 5)]`

commentaire: 
    `#[Assert\NotBlank]`

emailEtudiant:
    `#[Assert\Email]`  

### Professeur

nom:
    `#[Assert\NotBlank]`

prenom:
    `#[Assert\NotBlank]`

email:
    `#[Assert\Email]`

### Salle

numero:
    `#[Assert\NotBlank]`


# Choix techniques et pourquoi

## CRUD
### Cours
Lorsque l'on supprime un objet qui compose un cours (un professeur, une matière ou une salle), le cours est supprimé.
En effet, un cours qui n'a pas de professeur ou pas de matière ou pas de salle ne doit pas exister. 
Ce n'est pas logique d'avoir un cours qui n'a pas l'un de ces trois éléments

### NoteCours
Pour noter un cours, nous avons préféré créer une table NoteCours reliée à la table Cours.
Nous avons essayé de relier la table Avis à Cours et nous sommes rendu compte qu'il y allait avoir des conflits
de propriété (par exemple commentaire qui était le même pour professeur et cours). 

De plus, nous avons eu l'idée de rajouter des champs spécifiques au cours plus tard.
On pourrait par exemple évaluer les conditions de travail, est-ce que le matériel, les documents et autre ressources mises à disposition sont satisfaisantes.
L'étudiant a-t'il rencontré des difficultés pendant ce cours etc...
C'est pour cela qu'il nous a semblé plus judicieux de séparer l'avis d'un professeur et l'avis d'un cours.

# Fonctionnalitées aditionnelles

### Page matieres.html

Affiche chaque matières et leurs profs

# Implémenté mais ne fonctionne pas

Pour essayer de faire des expressions: pour faire des Assert sur les dates, j'ai ajouté le package expression-language

composer require symfony/expression-language

MARCHE PAS donc j'en suis restée à la vérification suivante:
Un cours ne peux pas commencer aujourd'hui et finir hier

# Problèmes rencontrés et difficultés

### Navigation entre les pages

Pour la navigation entre les pages, mettre dans une div un @click qui exécute une fonction pour rediriger(window.location.href = "vue.html") vers une page semblait une bonne solution, mais cela ne marchais pas et le click s'activais lorsque le div était chargé/reload. La solution a été de mettre une balise a ave un href.

### Note d'un cours

Nous voulions utiliser la meme table Avis que pour noter un prof mais cela cause des problèmes de conflits au niveau de la db.

# AUTRE
