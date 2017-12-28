# MailBundle

Symfony 3x bundle pour la gestion des emails.


Installation
------------

### Composer

Ajouter au `composer.json` les lignes suivantes:

```json
"require" : {
...
        "Orcaformation" : "dev-master"
    },
"repositories" : [{
        "type" : "vcs",
        "url" : "git@github.com:orcaformation/orcaMailBundle.git"
    }],    
```
et executer la commande:
`composer update "Orcaformation" `

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
### Ajouter au config.yml

Pour activer les extensions de doctrine ajouter au `config.yml` les lignes suivantes :

```yaml
#app/conﬁg/config.yml
sonata_admin:
    templates:
        edit:                OrcaMailBundle:CRUD:edit.html.twig
```

### Ajouter au routing.yml

Pour afficher la page d'administration ajouter au `routing.yml` les lignes suivantes :
 
```yaml
#app/conﬁg/routing.yml
orca_mail:
    resource: "@OrcaMailBundle/Resources/config/routing.yml"
    prefix:   /

```

### Configuration

Pour tracker les reqêtes émisent il faut ajouter aux services du projet la configuration suivante :

```yaml
#app/conﬁg/services.yml
services:
    Orca\UserLogBundle\EventListener\ResponseListener:
            class: Orca\UserLogBundle\EventListener\ResponseListener
            arguments:  ['@service_container']
            tags:
                - { name: kernel.event_listener, event: kernel.response, channel: security }
```

Pour tracker les login et les logout il faut ajouter les lignes suivantes au niveau du pare-feu de securité

```yaml
#app/config/security.yml
firewalls:
        secured_area:
            form_login:
                success_handler: orca_user_log.component.authentication.handler.login_success_handler
            logout:
                success_handler: orca_user_log.component.authentication.handler.logout_success_handler      # redirect, no_redirect, redirect_without_path
```