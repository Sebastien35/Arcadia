# Projet Arcadia

Le site d'un zoo fictif en bretagne

## Getting Started

Ces instructions vous permettront d'obtenir une copie du projet en cours d'exécution sur votre machine locale à des fins de développement et de test. Consultez le déploiement pour obtenir des notes sur la manière de déployer le projet sur un système en direct.

### Prérequis

What things you need to install the software and how to install them

```
PHP 8.2 or above
Symfony 5.7 or above
mySQL
Ver 15.1 Distrib
10.4.32-MariaDB
noSQL
  MongoDB:          7.0.6
```

### Installation

Un guide pas à pas pour créer un environnement de développement fonctionnel.

Cloner le repo
Créer un nouveau dossier, se positionner à l'aide d'un terminal  dans ce dossier et effectuer la commande:
```
git clone https://github.com/Sebastien35/Arcadia.git
```

Installer les dépendances avec composer
- A l'aide d'un terminal, se positionner dans le dossier ' Arcadia'
```
cd Arcadia
```
et effectuer la commande:
```
composer install
```
L'installation des dépendances peut prendre plusieurs minutes.

Créer la base de donneés
Un fichier sql permettant de créer la base de données et les tables est disponible dans le dossier'SQL'
S'y positionner depuis le dossier Arcadia:
```
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
Ajouter des données 
Pour pouvoir tester le site, des données sont nécéssaires.
Toujours dans le dossier SQL, un fichier 'inser_data.sql' permettant d'ajouter des données à notre nouvelle base données et disponible.
- utiliser le fichier:
```
source insert_data.sql
```

End with an example of getting some data out of the system or using it for a little demo

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Billie Thompson** - *Initial work* - [PurpleBooth](https://github.com/PurpleBooth)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone whose code was used
* Inspiration
* etc

