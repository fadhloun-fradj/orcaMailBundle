# MailBundle

Symfony 3x bundle pour la gestion des emails.


Installation
------------

### Composer

Ajouter au `composer.json` les lignes suivantes:

```json
"require" : {
        "orca/mailbundle" : "dev-master"
    },
"repositories" : [{
        "type" : "vcs",
        "url" : "git@github.com:orcaformation/orcaMailBundle.git"
    }],    
```
et executer la commande:
`composer update "orca/mailbundle" `

### Ajouter ce bundle au kernel

```php
//app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        // Orca Mail Bundle
        new Orca\MailBundle\OrcaMailBundle(),
        // ...
    );
}
```

### Ajouter au routing.yml

Ajouter au `routing.yml` les lignes suivantes :
 
```yaml
#app/conﬁg/routing.yml
orca_mail:
    resource: "@OrcaMailBundle/Resources/config/routing.yml"
    prefix:   /

```

### Configuration

Merci de saisir un mail d'admin pour recevoir les emails des exceptions/ + le nom du projet :

```php
#Util/Constants.php

    const MAIL_ADMIN = 'mbouasraf@orcaformation.fr';
    const PROJET = 'BENETEAU R7';

```

### Process d'envoi de mail avec la commande app:SendMail

Le Plugin de mail permet d'ordonner et d'automatiser l'envoi de mail à travers des règles, des types de mail ainsi que des vues.

Dans le but d'utiliser le plugin de mail il faut passer par un ensemble d'étapes:

1. Création d'un type de mail dans Mail Type avec wysiwyg ayant des tags au milieu de deux accolades {{}} comme par exemple: {{user_prenom}}
2. Création d'une vue dans (Mail Vue de données) comportant les requêtes SQL qui ont pour but d'alimenter les tags se trouvant dans le corps du mail
3. Création d'une règle via Mail Regle se fait ainsi: 
 * La règle devra être lié à la vue
 * La règle devra être lié au type de mail
 * La règle aura une fréquence d'envoi (immédiat,Tous les jours, Toutes les heures, Toutes les semaines)
 * La case "Regle Actif" devra être cocher dans le but qu'elle soit éxecuter

Par la suite nous pouvons utiliser la commande app:SendMail qui va executer les règles actives et donc envoyer le mail.

### Fonctinnalité d'envoie de mail StandAlone

Cette fonctionnalité permet d'envoyer des mails sans utiliser app:SendMail mais en utilisant tout simplement un service au sein du Plugin et pour cela il faut:

* Faire appel au service TblMailService se trouvant dans le plugin traiteMailTypeStandalone($mail_type_lib,$vue_data,$store)
* $mail_type_libelle (string): est le libellé u mail_type crée en base de donnée
* $vue_data[] (array): ce sont les différents tags se trouvant au niveau du body du type (mentionner le destinataire au niveau de la vue_data est obligatoire)
* $store (boolean): permet de stocker les informations du mail en base de donnée ou non Cette nouvelle fonctionnalité offre plus de flexibilité pour l'envoie de mail  tout en utilisant les différents composants du plugin de mail

### Fonctinnalité d'envoie d'objet php au mail type:

Cette fonctionnalité permet d'utiliser la puissance de twig en envoyant des objets php au niveau du template de mail venant de la vue en utilisant la command app:SendMail.

Dans le but d'utiliser cette fonctionnalité il faut:

1. Tout d'abord créer une vue dont la requête disposera de chaîne de caractère sous format json {"id":valeur_id, "type":"valeur_classe"} AS nom_du_tag (exemple {"id":4,"type":"App/Entity/nom_classe"})
* id: représente l'id de l'objet que l'on souhaite avoir
* type: représente la classe de l'objet tout en donnant le path de ce dernier
* Exemple de requête: SELECT user_id,'{"id":21235,"type":"App/Entity/nom_classe_user"}' AS user1,'{"id":34,"type":"App/Entity/nom_classe_document"}' AS document,'destinataire@teamwillgroup.com' AS destinataire FROM table_user etc

2. Après avoir créer la vue comportant la requête souhaité nous devons créer un type qui permettra de consommer les données rapporté par la vue
* Dans le but d'appeler l'objet php il suffit de mettre dans le template de mail {{nom_du_tag.attribut_de_classe}} (exemple: {{user1.userNom}} )
3. Créer la régle qui utiliser le type ainsi que la vue
4. Lancer la commande app: Send en utilisant:

 ```bash
    php bin/console app:SendMail
 ```


