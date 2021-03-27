# ppe_association_sportive_web
Répertoire du projet association sportive web

VERSION SYMFONY : 

	Symfony 5.2.1

REQUIS :

	PHP 7.4
	PhpMyAdmin 5.0.4
	Apache 2.4.46
	MySQL 8.0.22
	Sass 1.32

ATTENTION l'extension curl de php peut poser problème si votre serveur symfony est en https voir :
	https://docs.bolt.cm/3.7/howto/curl-ca-certificates

INSTALLATION

	- git clone https://github.com/divinoPV/ppe_association_sportive_web.git
	- lancer le projet dans votre IDE
	- ouvrir un terminal dans le dossier du projet et taper :
		- composer install
		- php bin\console d:d:c
		- php bin\console d:s:u -f
		- php bin\console d:fix:l -n
		! Si vous n'avez pas sass aller dans public\static\sass\style.scss et suivez le tuto
		- sass public/static/sass/style.scss public/static/css/style.css --watch
	- ajouter un fichier .env.local avec:
		APP_ENV=dev
		APP_SECRET= your secret
		DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/ppe_asso_sportive_symfony?serverVersion=8.0.22&charset=utf8"
		MAILER_DSN=gmail://USEREMAIL:PASSWORD@default
		ATTENTION caractères spéciaux en syntaxe URL (ex : + -> %2B)
	- créer un compte avec votre vrai adresse mail pour tester le mot de passe oublié
	- changer votre role en base pour être admin (syntax ["ROLE_ADMIN"])
	- aller sur \admin pour modifier les utilisateurs
	- déconnectez-vous et essayez mot de passe oublié (vous devez être le seul admin en base car notre système envoie un email à un administrateur au hasard)
	
	Par défaut le compte administrateur est :
		- Login : admin@gmail.com
		- Pass : 'Azerty123&@.
	
	Si vous avez une question vous pouvez me contacter à l'adresse suivante : hugomonteiro6021@gmail.com
	
CONTEXTE

	Développement d'un site web avec Symfony permettant de gérer les inscriptions aux événements sportifs.
	
ARCHITECTURE
	
	- Connexion
	- Accueil
		- Archive - Événements
			- Fiche - Événements
	- Mon profil
	- Contact
	- Oubli de mot de passe
	- Inscription
	
STACK TECHNIQUE
  
    Symfony 5.2
    D3JS
    SASS
    PHP 7.4
    ES6
	
PRODUCTION

	Laura Gonçalves
	Lucas Boganin
	Hugo Monteiro
