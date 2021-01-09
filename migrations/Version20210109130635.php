<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210109130635 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_stage (formation_id INT NOT NULL, stage_id INT NOT NULL, INDEX IDX_B4F70D1C5200282E (formation_id), INDEX IDX_B4F70D1C2298D193 (stage_id), PRIMARY KEY(formation_id, stage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_stage ADD CONSTRAINT FK_B4F70D1C5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_stage ADD CONSTRAINT FK_B4F70D1C2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage ADD entreprises_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A70A18EC FOREIGN KEY (entreprises_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_C27C9369A70A18EC ON stage (entreprises_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE formation_stage');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A70A18EC');
        $this->addSql('DROP INDEX IDX_C27C9369A70A18EC ON stage');
        $this->addSql('ALTER TABLE stage DROP entreprises_id');
    }
}
