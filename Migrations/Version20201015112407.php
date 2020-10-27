<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201015112407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
        INSERT INTO mail_tbl_mail_type (`mail_type_id`,`mail_type_lib`,`mail_type_objet`,`mail_type_expediteur`,
        `mail_type_cc`,`mail_type_bcc`,`mail_type_body`) VALUES 
        (1,"Type Defaut","Test",NULL,"","","<div>
        <p>Bonjour {{user_prenom}} {{user_nom}},</p><p>- identifiant : {{user_login}}</p><p>- mot de passe : {{user_password}}</p>");
        ');

        $this->addSql('
            INSERT INTO mail_tbl_vue (`vue_id`,`vue_lib`,`vue_sql_propel`,`vue_post_sql_raw`,`vue_sql_raw`) VALUES
            (1,"Vue Defaut",NULL,"Default","Default");
        ');
        $this->addSql('
        INSERT INTO mail_tbl_regle (`regle_lib`,`vue_id`,`mail_type_id`,`regle_heure`,`regle_frequence_id`,`regle_actif`,
        `regle_date_envoi`,`regle_renvoi`) VALUES 
        ("Regle defaut",1,1,"00:00:00",3,0,"2015-01-01 00:00:00",0)
    ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
