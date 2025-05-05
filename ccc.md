# CAHIER DE CHARGE ARCHEO - IT

* **CHAPITRE 1 : Contexte**
***
L’association “Archéo-IT” est une assiociations qui fait des decouverte archeologique et qui contribue dans diverse chantier partout en france. Elle souhaite obtenir de plus de visibilité en disposant d’un site WEB permettant de 
présenter l’ensemble de ses activités. Elle a donc fait appel à nos services pour repondre à ses besoins.
***
* **CHAPITRE 2 :  Objectifs de la solution**
***
OBJECTIF:

*Augmentation de la visibilité : Un site web attractif qui met en valeur les activités de l'association, attirant un plus large public*

*Facilité d'interaction : Un moyen pratique pour les visiteurs de contacter l'association et s'inscrire pour rester informés.*

*Organisation améliorée : Une base de données centralisée pour gérer les informations des inscrits.*
***
* **CHAPITRE 3: Acteurs et utilisateurs**
***
#### Maîtrise d’ouvrage : L'associations Archeo - IT
#### Maîtrise d'oeuvre : Kadidia Grace TCHIBINDA DIAW et Cedric Richard BINTCHA PIAME
#### Utilisateur : 
- Le public en generale souhaitant s'informer sur les activités de l'associations.
- Les passionnés d'archéologie intéressés par les chantiers de fouilles et les découvertes.
- Les Administrateurs du site.
- Les membres de l'association.
- D'autres associations, institutions culturelles ou entreprises collaborant avec Archéo-IT.
***
* **CHAPITRE 4: Périmètre du système**
***

*Présentation des activités de l'association, des chantiers de fouilles, des événements et des actualités.*

*Inscritions des utilisateurs et gestions du formulaire de contact.*

*Hebergement du site sur une machine virtuel*

#### Limites du systemes :
* Ne pas inclure la gestions des activités en dehors de celles directements liées à l'associations.
***
* **CHAPITRE 5: Règles métier**
***


***
* **CHAPITRE 6: Cas d’utilisation**
***
Lorsqu'un utilisateur ou visteur du site viens sur le site sans etre inscrits, sur la page d'acceuil on lui affiche les trois dernieres activé mené par l'associations avec un buttons pour voir les anciennes activités. Lorsque l'utilisateur clique sur se buttons en etant pas inscrit ca lui redirigera directement sur la page d'inscription du site pour qu'il puisse s'inscrire et juste apres l'avoir fait on lui redirige sur la page d'actualité avec toutes les actualités du sites. 

Si par hasard un utilisateur voulais en savoir plus sur une activité de l'association, en cliquant sur cette activité il sera directement conduit sur l'activité en questions avec une description complete sur la page d'actaulité. le visteur du site aura aussi la possibilité de voir un agenda demontrant quand ont eu lieux et quand aura encore lieux les differentes activités de l'associations. 

Ainsi apres avoir fais le tour du site et l'utilisateur est tenté d'entrer en contact avec un admin de l'association, il poura le faire sur la page contact du site en precisant le motif de son appel.

***
* **CHAPITRE 7: Besoins fonctionnels**
***
*Une page d’accueil listant sous forme de blog les dernières actualités de l’association (image et texte)*

*Une page présentant la liste des chantiers de fouilles auxquelles elle participe (dans toute la France) avec 
photos et description*

*Une page de contact (nom/prenom/mail/sujet sous forme de liste déroulante : Demande d’infos, Demande 
de Rendez-vous, Autre) alimentant une base de données*

*Le site doit pouvoir proposer aux visiteurs de s’inscrire*
* * Inscrit : Toutes les actualité du site.
* * Non inscrit : Seulement les 3 dernières actualités.

*Le site dois etre responsive et le plus attractif possible*

***
* **CHAPITRE 8: Interopérabilité et interfaces**
***

#### Systeme de Geolocalisations : *Indiquant l'emplacement des chantiers de fouilles partout en france.*

#### Systeme de monetisations des articles : *Permettant l'achats des reliques trouver par l'associations.*

***
* **CHAPITRE 9: Exigence de qualité du produits**
***

* * Lors de l'inscription le mot de passe doit etre generer automatiquement.
* *  Le mot de passe doit pouvoir afficher à la fois des majuscules et des minuscules.
* * Le code source du site ainsi que le script doit être hébergé sous github : le dépôt doit être public.

* * Le site doit être responsive et le plus attractif possible.
* * Le site doit pouvoir afficher les chantier de fouilles de l'association et les activité en fonction de si l'utilisateur est inscrit ou non.

***
* **CHAPITRE 10: Contraintes**
***

*Le site doit etre crée en utilisant du HTML / CSS / JS / PHP Obligatoirement*

*Les bases de données du sites en Mysql*

*Seule les Framework CSS sont autorisé.*

*Le sit dois etre heberger sur une machine virtuel*

*Mot de passe generer en python*

*Groupe de 2 à 3 personnes maximum pour la realisations du site.*
***
* **CHAPITRE 11:  Prestations et fournitures attendues**
***

* *Cahier de Charge.*
* *Documentation sur les etapes d'installation de la machine virtuel.*
* *Un lien vers le repository git.*

***
* **CHAPITRE 12: ANNEXES**
***
*Power point lors de la presentation du projet*

*Prototype du site web fait sur Figma/Canvas*

*Planning du projet*