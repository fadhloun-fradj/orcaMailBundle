<?php

declare(strict_types=1);

namespace OrcaMailBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103103210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `mail_tbl_mail` DROP INDEX `fk_mailtype`, ADD KEY `IDX_39D138E81FF10DFC` (`mail_type_id`)');
        $this->addSql('ALTER TABLE `mail_tbl_mail` DROP INDEX `mail_tbl_mail_fk_1`, ADD KEY `IDX_39D138E88E12947B` (`regle_id`)');
        $this->addSql('ALTER TABLE `mail_tbl_regle` DROP INDEX `fk_mail_tbl_regle_frequence_id`, ADD KEY `IDX_267E7B263C86AF9B` (`regle_frequence_id`)');
        $this->addSql('ALTER TABLE `mail_tbl_regle` DROP INDEX `fk_mail_tbl_regle_vue_id`, ADD KEY `IDX_267E7B26C8733BD3` (`vue_id`)');
        $this->addSql('ALTER TABLE `mail_tbl_regle` DROP INDEX `fk_mail_tbl_regle_mail_type_id`, ADD KEY `IDX_267E7B261FF10DFC` (`mail_type_id`)');
        $this->addSql('ALTER TABLE mail_tbl_mail DROP FOREIGN KEY mail_tbl_mail_FK_1');
        $this->addSql('ALTER TABLE mail_tbl_mail ADD CONSTRAINT FK_39D138E88E12947B FOREIGN KEY (regle_id) REFERENCES mail_tbl_regle (regle_id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
