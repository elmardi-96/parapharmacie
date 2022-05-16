<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325111520 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pproduit ADD livraisondet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pproduit ADD CONSTRAINT FK_7DBB7DA038DDA1DE FOREIGN KEY (livraisondet_id) REFERENCES vlivraisondet (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7DBB7DA038DDA1DE ON pproduit (livraisondet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pproduit DROP FOREIGN KEY FK_7DBB7DA038DDA1DE');
        $this->addSql('DROP INDEX UNIQ_7DBB7DA038DDA1DE ON pproduit');
        $this->addSql('ALTER TABLE pproduit DROP livraisondet_id');
    }
}
