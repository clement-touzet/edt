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

Liste des cours pour une date précise
/api/cours/cours-from-date?annee=AAAA&mois=MM&jour=JJ

```
[http://localhost:8000/api/cours/cours-from-date?annee=2023&mois=03&jour=04](http://localhost:8000/api/cours/cours-from-date?annee=2023&mois=03&jour=04)
```

### Salles

Pour obtenir la liste des salles
/api/salles

# Validateurs ajoutés

### Cours

dateHeureDebut:  
 `#[Assert\Type("\DateTimeInterface")] //pour être sûr qu'on reçoit le bon type de date`

dateHeureFin: `#[Assert\GreaterThan(propertyPath:"dateHeureDebut", message:"La date de fin ne peut pas être inférieure à la date de début")] //Pour s'assurer que la date de fin d'un cours est supérieure à la date de début (évite de faire des cours qui commencent le 06 et finissent le 05)`

type:
`#[Assert\Choice(['TD','TP','Cours'])] //On s'assure que le choix TD, TP ou cours est imposé`

professeur, salle et matiere: `#[Assert\NotBlank] //Pour être sûr que les champs soient bien remplis`

# Choix techniques et pourquoi

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
