Commandes à executer pour le vhost
Prérequis

Avant de faire quoi que ce soit, vérifie bien que le chemin absolue dans le fichier.conf correspond avec ta machine !
Activer le vhost

Voici toutes les commandes que vous devez faire pour activer votre vhost :

sudo cp env/flaglog.conf /etc/apache2/sites-available/flaglog.conf
sudo apache2ctl -t
sudo a2ensite flaglog.conf
sudo service apache2 reload

Activer l'host sur Windows pour la reconnaissance de l'URL

Pour ce faire ouvrez le bloc-notes en tant qu'administrateur, puis ouvrez le fichier hosts qui se trouve dans C:\Windows\System32\drivers\etc.

Copiez-y les lignes suivantes en fin de fichier :

127.0.0.1       flaglog
::1             flaglog

Vérifier l'adresse

En vous rendant sur flaglog.loc/ , vous devez tomber sur le site.

Si ce n'est pas le cas, vérifiez les étapes que vous venez de faire.

Rapport FlagGame


Description:
Descriptif (fiabilité):
Valeurs limites:
Conclusion:

Description:
Notre application est un site web qui utilise une API de drapeau avec des logs dans le cadre du M110.
Fonctionnalités
Connection et création de compte
Accès au quiz
Accès au score / scoreboard
Possibilité de changer de mot de passe

Architecture:
 

Descriptif (fiabilité): 

Faut faire attention que le site est bien connecter avec la BDD 
Faut faire attention à ce que l’API soit accessible
Faut faire attention à ce que personne ne peut tricher 
Faut faire attention au donnée que l’on a récupérer  (anonyme)

Nous allons veiller au mieux à la sécurité et au bon fonctionnement du site
en utilisant des logs de différentes forces qui permettent de protéger et d’agir au plus vite si nécessaire.
Valeurs limites :
Détection d’erreurs de triche: Si le score de quelqu’un augmente de plus de 10 en un coup un log d’alerte remonte pour tricherie de même si un highest score est plus haut que le réel score d’un joueur.
Tentatives de connexion excessives : Si un utilisateur tente de se connecter plusieurs fois de manière infructueuse, un log d’alerte sera généré pour prévenir d’une tentative de connexion potentiellement frauduleuse ou d’une attaque par force brute. Une restriction temporaire d’accès peut être appliquée pour renforcer la sécurité du site.
Accessibilité de l’API : L’API doit être fonctionnelle en permanence pour assurer le bon fonctionnement du site. Si une interruption ou un dysfonctionnement est détecté, un log critique sera généré afin de notifier immédiatement l’équipe technique pour une intervention rapide. Des vérifications régulières seront mises en place pour garantir la disponibilité de l’API et minimiser les interruptions de service.

Conclusion: 
Le projet a duré le temps que nous avions prévu. Tout le monde a travaillé comme il le fallait, et le travail a bien été réparti afin que chacun ait une part égale.Le projet à été amusant à faire car notre site est composé d’un jeu de drapeau.Et nous avons plutot été bien organiser nous avons pas penser trop grand ni petit on a réussi à faire tout ce que l’on voulait faire plus ajouter des fonctionnalités que nous avions pas prévus au début.

