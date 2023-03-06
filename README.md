/** CAZENAVE Mathilde - TOUZET Clément **/ 

/** PROCESS D'INSTALLATION DU PROJET **/
/* Cours */
    Pour obtenir la liste de tous les cours:
    /api/cours

    Obtenir la liste des cours pour une date précise
    /api/cours/cours-from-date?annee=aaaa&mois=mm&jour=jj

/* Salles */    
    Pour obtenir la liste des salles
    /api/salles

/** DEFINITION DES POINTS D'ENTREE DE L'API**/

/** VALIDATEURS AJOUTES **/

/** CHOIX TECHNIQUES ET POURQUOI **/

/** FONCTIONNALITES ADDITIONELLES **/

/** IMPLEMENTE MAIS NE FONCTIONNE PAS **/

/** AUTRE **/


Pour essayer de faire des expressions: pour faire des Assert sur les dates, j'ai ajouté le package expression-language

composer require symfony/expression-language

MARCHE PAS donc j'en suis restée à la vérification suivante:
Un cours ne peux pas commencer aujourd'hui et finir hier
