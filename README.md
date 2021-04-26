# ppe_association_sportive_web

Développement d'un site web avec Symfony permettant de gérer les inscriptions aux événements sportifs.

## Symfony

```text
Symfony 5.2.5
```

## Requis

```text
Php (7.4)
Composer (1.*)
Node

ATTENTION l'extension curl de php peut poser problème si votre serveur symfony est en https voir :
	https://docs.bolt.cm/3.7/howto/curl-ca-certificates
```

## Installation

```bash
# Créer un dossier et exécuter dans le terminal :
git clone https://github.com/divinoPV/ppe_association_sportive_web.git
cd # [nom du fichier]

# Init projet commande
composer install
yarn install && yarn encore dev

# BDD commande
php bin\console d:d:c
php bin\console d:s:u -f
php bin\console d:fix:l -n
```

```text
# Ajouter un fichier .env.local avec :
APP_ENV=dev
APP_SECRET= your secret
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/ppe_asso_sportive_symfony?serverVersion=8.0.22&charset=utf8"
MAILER_DSN=smtp://localhost:1025
```

```text
# Pour voir les mails reçus ou envoyés :
Lancer bin\MailLog.exe
Aller sur localhost:8025
Aller sur \admin pour modifier les utilisateurs
Déconnectez-vous et essayez mot de passe oublié 
(vous devez être le seul admin en base car notre système envoie un email à un administrateur au hasard)

Par défaut le compte administrateur est :
	- Login : admin@gmail.com
	- Pass : 'Azerty123&@.
```

## Support

Si vous avez besoin d'aide vous pouvez contacter [divinoPV](mailto:monteiro.hugo2001@icloud.com?subject=[GitHub]%20Source%20Han%20Sans)
	
## Stacks

```text
Symfony 5.2
ChartJS
SASS
PHP 7.4
ES6
```
	
## Authors

```text
Laura Gonçalves
Lucas Boganin
Hugo Monteiro
```