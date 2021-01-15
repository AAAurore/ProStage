<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210115212317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise DROP activite');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A70A18EC');
        $this->addSql('DROP INDEX IDX_C27C9369A70A18EC ON stage');
        $this->addSql('ALTER TABLE stage ADD activite VARCHAR(100) DEFAULT NULL, CHANGE entreprises_id entreprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_C27C9369A4AEAFEA ON stage (entreprise_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise ADD activite VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A4AEAFEA');
        $this->addSql('DROP INDEX IDX_C27C9369A4AEAFEA ON stage');
        $this->addSql('ALTER TABLE stage DROP activite, CHANGE entreprise_id entreprises_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A70A18EC FOREIGN KEY (entreprises_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_C27C9369A70A18EC ON stage (entreprises_id)');
    }
}
