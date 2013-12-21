*mise à jour : il semble que [certains](http://claire-berthelemy.fr/2013/12/data-les-aides-a-la-presse-version-2012/) aient pu exploiter les données et donc certainement les extraire d'une manière ou d'une autre, cette piste sera donc à voir comme une alternative à d'autres solutions, certainement plus simple. Le plus simple aurait bien entendu été que ce fichier soit directement joint au communiqué de presse.*

**Mise à jour 2 : Ces données sont disponibles au format tabulé sur le site [data.gouv.fr](http://www.data.gouv.fr/fr/dataset/montants-d-aides-pour-les-200-titres-de-presse-les-plus-aides) ... Travail inutile donc, archivé quand même pour mémoire.**

Aides à la presse 
============
Contexte
----
Le 13 décembre 2013, le ministère de la Culture et de la Communication a publié sur son site web [un communiqué de presse](http://www.culturecommunication.gouv.fr/Actualites/Dossiers/Aides-a-la-presse-les-chiffres-2012 "") qui signale la mise à disposition des chiffres des aides à la presse versées pour l'année 2012. Ce communiqué de presse s'accompagne de deux fichiers : 
* [Tableau des montants totaux d’aides pour les 200 titres de presse les plus aidés](http://www.culturecommunication.gouv.fr/content/download/84457/636216/file/131210_MinistereCultureCom_AidePresse-200titres.pdf)
* [Note explicative pour la publication des 200 titres de presse les plus aidés](http://www.culturecommunication.gouv.fr/content/download/84458/636220/file/131210_MinistereCultureCom_AidePresse-200titres_fiche-presentation.pdf)

Le tableau des montants totaux d'aide est particulièrement intéressant et a donné lieu à plusieurs publications : 
* [« Closer » écrase « Le Monde diplomatique »](http://www.monde-diplomatique.fr/carnet/2013-12-19-aides) sur le site du Monde Diplomatique (19/12/2013)
* [[DATA] Les aides à la presse, version 2012](http://claire-berthelemy.fr/2013/12/data-les-aides-a-la-presse-version-2012/) par Claire Berthelemy
* [Aides à la presse : « Le Monde » et « Le Figaro » sont les mieux dotés](http://www.lemonde.fr/actualite-medias/article/2013/12/12/aides-a-la-presse-le-monde-et-le-figaro-sont-les-mieux-dotes_4333547_3236.html) sur le site du Monde (12/12/2013)

Le problème principal est que les données fournies par le ministère est un PDF, difficilement exploitable, alors que le fichier est presqu'exclusivement composé d'informations tabulaires. Un fichier de format tableur permettrait plus d'exploitation, une analyse plus précise.

Les données
----
Suite à l'extraction des données (voir paragraphe suivant) et à quelques adaptations manuelles (le script aurait pu résoudre tous les problèmes mais pour une extraction unique il ne nous a pas semblé nécessaire de pousser plus le développement.

Extraction des données
----
Le fichier PDF fourni par le ministère a été transformé en XML à l'aide du programme pdftohtml utilisé avec l'option -xml. Le fichier résultant comprend l'ensemble des groupes de mot du fichier, avec pour chacun leurs coordonnées par rapport à la page. 

Ce fichier XML a ensuite était traité à l'aide d'un script PHP développé spécifiquement pour ce cas : analyse.php. Il présente quelques bugs pour certains cas où l'information est sur plusieurs lignes.