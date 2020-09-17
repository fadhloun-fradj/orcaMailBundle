# MailBundle

Symfony 3x bundle pour la gestion des emails.

Introduction
------------

Ce bundle à pour gérer : 
- L'envoi des emails.
- Gérer les excepions des email invalid.
- Gérer le template des emails.

## Documentation

La documentation est au niveau du fichier `Resources/doc/index.md` :

[Lire la documentation](https://github.com/orcaformation/orcaMailBundle/tree/master/Resources/doc/index.md)

## Credits

- [OrcaFormation](https://github.com/orcaformation)

## Dans le but de pouvoir utiliser le plugin de mail il faut:

1- Cree un fichier orca_mail.yaml au niveau de config/packages/orca_mail.yaml
2- Ajouter au fichier orca_mail.yaml au niveau les parametres:

orca_mail:
    is_mail_enabled: 0
    is_mail_destinataire_enabled: 1
    mail_destinataire:
    mail_expediteur:
    mail_nbr: 50
    projet:
