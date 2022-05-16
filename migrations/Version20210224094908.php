<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224094908 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE particle ADD user_create_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE particle ADD CONSTRAINT FK_56249FE1EEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_56249FE1EEFE5067 ON particle (user_create_id)');
        $this->addSql('ALTER TABLE pdossier ADD user_create_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pdossier ADD CONSTRAINT FK_695671B0EEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_695671B0EEFE5067 ON pdossier (user_create_id)');
        $this->addSql('ALTER TABLE pfornisseur ADD user_create_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pfornisseur ADD CONSTRAINT FK_B526279FEEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B526279FEEFE5067 ON pfornisseur (user_create_id)');
        $this->addSql('ALTER TABLE tstock ADD user_create_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tstock ADD CONSTRAINT FK_AC654F09EEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC654F09EEFE5067 ON tstock (user_create_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE particle DROP FOREIGN KEY FK_56249FE1EEFE5067');
        $this->addSql('DROP INDEX IDX_56249FE1EEFE5067 ON particle');
        $this->addSql('ALTER TABLE particle DROP user_create_id');
        $this->addSql('ALTER TABLE pdossier DROP FOREIGN KEY FK_695671B0EEFE5067');
        $this->addSql('DROP INDEX IDX_695671B0EEFE5067 ON pdossier');
        $this->addSql('ALTER TABLE pdossier DROP user_create_id');
        $this->addSql('ALTER TABLE pfornisseur DROP FOREIGN KEY FK_B526279FEEFE5067');
        $this->addSql('DROP INDEX IDX_B526279FEEFE5067 ON pfornisseur');
        $this->addSql('ALTER TABLE pfornisseur DROP user_create_id');
        $this->addSql('ALTER TABLE tstock DROP FOREIGN KEY FK_AC654F09EEFE5067');
        $this->addSql('DROP INDEX IDX_AC654F09EEFE5067 ON tstock');
        $this->addSql('ALTER TABLE tstock DROP user_create_id');
    }
}
