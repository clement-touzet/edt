/** CAZENAVE Mathilde - TOUZET Clément **/

/** PROCESS D'INSTALLATION DU PROJET **/

/** DEFINITION DES POINTS D'ENTREE DE L'API**/
## Cours
Pour obtenir la liste de tous les cours:
/api/cours

    Obtenir la liste des cours pour une date précise
    /api/cours/cours-from-date?annee=aaaa&mois=mm&jour=jj

## Salles
Pour obtenir la liste des salles
/api/salles

/** VALIDATEURS AJOUTES **/
## Cours
dateHeureDebut:  
    #[Assert\Type("\DateTimeInterface")] //pour être sûr qu'on reçoit le bon type de date

dateHeureFin:
    #[Assert\GreaterThan(propertyPath:"dateHeureDebut", message:"La date de fin ne peut pas être inférieure à la date de début")] //Pour s'assurer que la date de fin d'un cours est supérieure à la date de début (évite de faire des cours qui commencent le 06 et finissent le 05)

type:
    #[Assert\Choice(['TD','TP','Cours'])] //On s'assure que le choix TD, TP ou cours est imposé

professeur, salle et matiere: 
     #[Assert\NotBlank] //Pour être sûr que les champs soient bien remplis



/** CHOIX TECHNIQUES ET POURQUOI **/

/** FONCTIONNALITES ADDITIONELLES **/
---Page matieres.html
Affiche chaque matières et leurs profs

/** IMPLEMENTE MAIS NE FONCTIONNE PAS **/
Pour essayer de faire des expressions: pour faire des Assert sur les dates, j'ai ajouté le package expression-language

composer require symfony/expression-language

MARCHE PAS donc j'en suis restée à la vérification suivante:
Un cours ne peux pas commencer aujourd'hui et finir hier

/** PROBLEMES RENCONTRES/DIFFICULTES **/
--- Pour la navigation entre les pages, mettre dans une div un @click qui exécute une fonction pour rediriger(window.location.href = "vue.html") vers une page semblait une bonne solution, mais cela ne marchais pas et le click s'activais lorsque le div était chargé/reload. La solution a été de mettre une balise a ave un href.
--- Nous voulions utiliser la meme table Avis que pour noter un prof mais cela cause des problèmes de conflits au niveau de la db.
/** AUTRE **/
