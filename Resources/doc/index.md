# MailBundle

Symfony 3x bundle pour la gestion des emails.


Installation
------------

### Composer

Ajouter au `composer.json` les lignes suivantes:

```json
"require" : {
        "Orcaformation" : "dev-master"
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