## Commandes à executer pour le vhost
### Prérequis
Avant de faire quoi que ce soit, vérifie bien que **le chemin absolue** dans le fichier.conf **correspond avec ta machine !**

### Activer le vhost
Voici toutes les commandes que vous devez faire pour activer votre vhost :
```bash
sudo cp env/flaglog.conf /etc/apache2/sites-available/flaglog.conf
sudo apache2ctl -t
sudo a2ensite flaglog.conf
sudo service apache2 reload
```

### Activer l'host sur Windows pour la reconnaissance de l'URL
Pour ce faire ouvrez le bloc-notes **en tant qu'administrateur**, puis ouvrez le fichier `hosts` qui se trouve dans `C:\Windows\System32\drivers\etc`.

Copiez-y les lignes suivantes en fin de fichier :
```
127.0.0.1       flaglog
::1             flaglog
```

### Vérifier l'adresse
En vous rendant sur
<a href="http://flaglog/">
    <button>flaglog.loc/</button>
</a>, vous devez tomber sur le site.

Si ce n'est pas le cas, vérifiez les étapes que vous venez de faire.