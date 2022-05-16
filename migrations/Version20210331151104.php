<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331151104 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pclient ADD dossier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pclient ADD CONSTRAINT FK_782AAA3611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('CREATE INDEX IDX_782AAA3611C0C56 ON pclient (dossier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pclient DROP FOREIGN KEY FK_782AAA3611C0C56');
        $this->addSql('DROP INDEX IDX_782AAA3611C0C56 ON pclient');
        $this->addSql('ALTER TABLE pclient DROP dossier_id');
    }
}
