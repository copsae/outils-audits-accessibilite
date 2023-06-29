# La Moulinette, automatiseur de liste d’anomalies

La Moulinette est un outil développé par @mloyat pour Copsaé.

Cet outil permet de récupérer la liste de toutes les anomalies relevées dans une grille d’audit de conformité dans une seule feuille du tableur avec une ligne par anomalie.

Ainsi, les anomalies peuvent être comptées facilement et sont filtrables par impact. Cela permet de faciliter la priorisation des corrections et, éventuellement, l’export dans un outil de gestion des tickets.

## Comment l’utiliser ?

Il y a deux solutions :

- Vous pouvez télécharger l’outil en local sur votre ordinateur et le lancer grâce à un serveur Apache.
    - Vous devrez installer Composer et lancer la commande `composer install` à la racine du dossier « moulinette/ ».
- Vous pouvez également utiliser directement l’outil en ligne à cette adresse : [moulinette.copsae.fr](https://moulinette.copsae.fr/).
    À titre d’information, les fichiers que vous mettez dans le champ de formulaire ne sont pas enregistrés sur notre serveur et le site ne récolte aucune statistique ou autre.
