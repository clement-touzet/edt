/** CAZENAVE Mathilde - TOUZET Clément **/

/** PROCESS D'INSTALLATION DU PROJET **/

/** DEFINITION DES POINTS D'ENTREE DE L'API**/
--- Cours
Pour obtenir la liste de tous les cours:
/api/cours

    Obtenir la liste des cours pour une date précise
    /api/cours/cours-from-date?annee=aaaa&mois=mm&jour=jj

--- Salles
Pour obtenir la liste des salles
/api/salles

/** VALIDATEURS AJOUTES **/

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
