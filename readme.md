# __Projet Arcadia__
Le site d'un zoo fictif en bretagne
## __Getting Started__

Ces instructions vous permettront d'obtenir une copie du projet en cours d'exécution sur votre machine locale à des fins de développement et de test. Consultez le déploiement pour obtenir des notes sur la manière de déployer le projet sur un système en direct.

### __Prérequis__

PHP 8.2 or above </br>
Symfony CLI 5.7 or above </br>
Symfony 7.0.5 or above <br />
mySQL </br>
noSQL </br>
MongoDB: 7.0.6 </br>
VSCODE </br>
GIT </br>

### __Installation__
Un guide pas à pas pour créer un environnement de développement fonctionnel.

#### Installer Git

__Windows__ </br>
Installer Scoop
```
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
```
Installer git
```
scoop install git
````

#### Installer Symfony CLI
```
scoop install symfony-cli
```

#### Vérifier l'installation
```
symfony check:requirements -v
```

#### Cloner le repo </br>
-Créer un nouveau dossier, se positionner à l'aide d'un terminal  dans ce dossier et effectuer la commande:
```
mkdir ECF_SB
```
```
cd ECF_SB
```
```
git clone https://github.com/Sebastien35/Arcadia.git
```

#### Configurer les variables d'environnement:

Afin de pouvoir tester correctement ce projet il nous faut également configurer les variables d'environnement:
Se positionner dans le dossier Arcadia, créer un fichier nommé .env.local
Dans ce fichier, ajouter les lignes suivantes:
```
cd Arcadia
```
Puis créer le fichier .env.local
Windows powershell:
```
ni .env.local
```
Linux: 
```
touch .env.local
```
Dans ce fichier .env.local , ajouter les variables d'environnement:

```
DATABASE_URL="mysql://root@127.0.0.1:3306/arcadia_db?serverVersion=10.11.2-MariaDB&charset=utf8mb4" 

MAILER_DSN=mailjet+smtp://104ac58d97c7d19f3df5a298c7359548:998fa0a0d4cdf5f2c4d42d859b8e6fef@in-v3.mailjet.com

MONGODB_URL=mongodb://localhost:27017 
```
#### Installer les dépendances avec composer
- A l'aide d'un terminal, se positionner dans le dossier ' Arcadia'
```
cd Arcadia
```
Installer les dépendances
```
composer install
```
L'installation des dépendances peut prendre plusieurs minutes.
### Créer et remplir la base de données:
Pendant les trois prochaines étapes, nous allons: </br>
- Créer la base données </br>
- Insérer des comptes utilisateurs dans la base de données </br>
- Insérer d'autres données dans la base.  </br>
Il est important de respecter l'ordre des consignes.
#### Créer la base de donneés
-Un fichier sql permettant de créer la base de données et les tables est disponible dans le dossier Documentation\SQL </br>
-S'y positionner depuis le dossier Arcadia:
```
cd Documentation
cd SQL
``` 
Créer la base de données en se servant du fichier sql:
- se connecter à mysql
```
mysql -u \votreUsername\ -p\votrePassword\
````
- utiliser le fichier
```
source creation_db.sql
```
Quitter mysql (ctrl / cmd + c) & Revenir au dossier Arcadia:
```
cd ../../
```
#### Créer les comptes utilisateurs: </br>
Toujours dans l'optique de pouvoir tester le site, il nous faut créer les différents comptes pour accéder au site.
La création des comptes se fera à l'aide de fixtures doctrine.
- Charger les fixtures:
  Se positionner dans le dossier Arcadia avec un terminal, et effectuer la commande suivante, **sans oublier le --apend**:
```
symfony console doctrine:fixtures:load --append
```
#### Ajouter des données: </br>
Se positonner dans le dossier SQL.
```
cd documentation\sql
```
Ouvrir mySQL
```
mysql -u \votreUsername\ -p\votrePassword\
```
Un fichier 'inser_data.sql' permettant d'ajouter des données à notre nouvelle base données et disponible.

```
source insert_data.sql
```
** Nous avons désormais une base de données avec différentes tables, sur laquelle nous avons envoyé des données. ** </br>
Nous avons également inséré en base de données les comptes utilisateurs qui nous servirons à nous connecter au site web avec différents roles.</br>
Un autre compte existe, mais représentant une personne extérieure au zoo, il n'a pas été inséré en base de données.
Il servira à tester la fonctionnalité de mailing plus tard.





aaaaa