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

## orca_mail:
Ajout du fichier orca_mail.yaml au niveau de config/packages/
    is_mail_enabled: 0
    is_mail_destinataire_enabled: 1
    mail_destinataire: 
    mail_expediteur:
    mail_nbr: 50
    projet:

NB : is_mail_enabled doit être a 0 pour ne pas envoyer de mail réel aux adresses. A la mise à 1 en executant la        commande les mails sont envoyés aux destinataires.
     is_mail_destinataire doit être a 0 pour que les adresses puissent être affiché en BD. A la mise a les mails seront envoyé au mail_destinataire ou bien MAIL_ADMIN (donotreply@orcagroup.com)
     mail_destinataire: Mettre le mail destinataire
     mail_expediteur: Mettre un mail expediteur specifique. Par défaut il prend le MAIL_ADMIN
     mail_nbr: Nombre de mail a envoye apres chaque execution de commande 