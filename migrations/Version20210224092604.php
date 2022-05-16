<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224092604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE particle (id INT AUTO_INCREMENT NOT NULL, dossier_id INT DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, abreviation VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, INDEX IDX_56249FE1611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pfornisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tstock (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, dossier_id INT DEFAULT NULL, quantite INT NOT NULL, date_creation DATE DEFAULT NULL, date_modification DATE DEFAULT NULL, INDEX IDX_AC654F097294869C (article_id), INDEX IDX_AC654F09611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE particle ADD CONSTRAINT FK_56249FE1611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE tstock ADD CONSTRAINT FK_AC654F097294869C FOREIGN KEY (article_id) REFERENCES particle (id)');
        $this->addSql('ALTER TABLE tstock ADD CONSTRAINT FK_AC654F09611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tstock DROP FOREIGN KEY FK_AC654F097294869C');
        $this->addSql('DROP TABLE particle');
        $this->addSql('DROP TABLE pfornisseur');
        $this->addSql('DROP TABLE tstock');
        $this->addSql('DROP TABLE user');
    }
}
