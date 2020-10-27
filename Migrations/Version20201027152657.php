<?php

declare(strict_types=1);

namespace OrcaMailBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027152657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql("DROP TABLE IF EXISTS `mail_tbl_mail`;");
        $this->addSql("DROP TABLE IF EXISTS `mail_tbl_regle`");
        $this->addSql("DROP TABLE IF EXISTS `mail_tbl_regle_frequence`;");
        $this->addSql("DROP TABLE IF EXISTS `mail_tbl_vue`;");
        $this->addSql("DROP TABLE IF EXISTS `mail_tbl_mail_type`");

        //Creation de mail_tbl_type
        $this->addSql("
        CREATE TABLE `mail_tbl_mail_type`(
          `mail_type_id` int(11) NOT NULL AUTO_INCREMENT,
          `mail_type_lib` varchar(64) NOT NULL,
          `mail_type_objet` varchar(255) NOT NULL,
          `mail_type_expediteur` varchar(64) DEFAULT NULL,
          `mail_type_cc` varchar(512) DEFAULT NULL,
          `mail_type_bcc` varchar(512) DEFAULT NULL,
          `mail_type_actif` tinyint(1) NOT NULL DEFAULT '1',
          `mail_type_body` text,
          PRIMARY KEY (`mail_type_id`)) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;");

        //Creation de mail_tbl_vue
        $this->addSql("
        CREATE TABLE `mail_tbl_vue` (
          `vue_id` int(11) NOT NULL AUTO_INCREMENT,
          `vue_lib` varchar(64) NOT NULL,
          `vue_sql_propel` text,
          `vue_post_sql_raw` text,
          `vue_sql_raw` text,
          PRIMARY KEY (`vue_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
        ");

        //Creation de mail_tbl_regle_frequence
        $this->addSql("
          CREATE TABLE `mail_tbl_regle_frequence` (
            `regle_frequence_id` int(11) NOT NULL AUTO_INCREMENT,
            `regle_frequence_lib` varchar(32) NOT NULL,
            `regle_frequence_delai` varchar(64) NOT NULL,
            PRIMARY KEY (`regle_frequence_id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
          ");
        

        //Creation de mail_tbl_regle
        $this->addSql("
        CREATE TABLE `mail_tbl_regle` (
          `regle_id` int(11) NOT NULL AUTO_INCREMENT,
          `regle_lib` varchar(64) NOT NULL,
          `vue_id` int(11) NOT NULL,
          `mail_type_id` int(11) NOT NULL,
          `regle_heure` time NOT NULL DEFAULT '00:00:00',
          `regle_frequence_id` int(11) NOT NULL,
          `regle_actif` tinyint(1) NOT NULL DEFAULT '0',
          `regle_date_envoi` datetime NOT NULL DEFAULT '2009-01-01 00:00:00',
          `regle_renvoi` tinyint(1) NOT NULL DEFAULT '0',
           PRIMARY KEY (`regle_id`),
           KEY `FK_mail_tbl_regle_mail_type_id` (`mail_type_id`),
           KEY `FK_mail_tbl_regle_frequence_id` (`regle_frequence_id`),
           KEY `FK_mail_tbl_regle_vue_id` (`vue_id`),
           CONSTRAINT `mail_tbl_regle_FK_1` FOREIGN KEY (`vue_id`) REFERENCES `mail_tbl_vue` (`vue_id`),
           CONSTRAINT `mail_tbl_regle_FK_2` FOREIGN KEY (`mail_type_id`) REFERENCES `mail_tbl_mail_type` (`mail_type_id`),
           CONSTRAINT `mail_tbl_regle_FK_3` FOREIGN KEY (`regle_frequence_id`) REFERENCES `mail_tbl_regle_frequence` (`regle_frequence_id`)) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
        ");
          
        //Creationd de mail_tbl_mail
        $this->addSql("
        CREATE TABLE `mail_tbl_mail` (
            `regle_id` int(11) NOT NULL,
            `mail_object` varchar(255) NOT NULL,
            `mail_expediteur` varchar(64) DEFAULT NULL,
            `mail_destinataire` varchar(512) NOT NULL,
            `mail_cc` varchar(512) DEFAULT NULL,
            `mail_bcc` varchar(512) DEFAULT NULL,
            `mail_body` text,
            `mail_vue_data` text,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `mail_type_id` int(11) DEFAULT NULL,
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` varchar(64) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `mail_tbl_mail_FK_1` (`regle_id`),
            KEY `FK_MailType` (`mail_type_id`),
            CONSTRAINT `FK_MailType` FOREIGN KEY (`mail_type_id`) REFERENCES `mail_tbl_mail_type` (`mail_type_id`),
            CONSTRAINT `mail_tbl_mail_FK_1` FOREIGN KEY (`regle_id`) REFERENCES `mail_tbl_regle` (`regle_id`) ON UPDATE CASCADE) ENGINE=InnoDB AUTO_INCREMENT=65536 DEFAULT CHARSET=utf8;");
     
        $this->addSql("
        INSERT  INTO `mail_tbl_regle_frequence`(`regle_frequence_id`,`regle_frequence_lib`,`regle_frequence_delai`) values 
        (1,'Tous les jours','23 hours 51 minutes'),
        (2,'Toutes les heures','51 minutes'),
        (3,'Immediat','1 second'),
        (4,'Toutes les semaines','6 days 23 hours 51 minutes');
        ");

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

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
