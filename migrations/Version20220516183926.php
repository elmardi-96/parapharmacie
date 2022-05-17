<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516183926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE particle (id INT AUTO_INCREMENT NOT NULL, dossier_id INT DEFAULT NULL, user_create_id INT DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, abreviation VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, INDEX IDX_56249FE1611C0C56 (dossier_id), INDEX IDX_56249FE1EEFE5067 (user_create_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pclient (id INT AUTO_INCREMENT NOT NULL, user_create_id INT DEFAULT NULL, dossier_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, adresse LONGTEXT DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, INDEX IDX_782AAA3EEFE5067 (user_create_id), INDEX IDX_782AAA3611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pdossier (id INT AUTO_INCREMENT NOT NULL, user_create_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, abreviation VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, active INT DEFAULT NULL, id_ugouv INT DEFAULT NULL, INDEX IDX_695671B0EEFE5067 (user_create_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pfornisseur (id INT AUTO_INCREMENT NOT NULL, user_create_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, date_creation DATE DEFAULT NULL, INDEX IDX_B526279FEEFE5067 (user_create_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pproduit (id INT AUTO_INCREMENT NOT NULL, livraisoncab_id INT DEFAULT NULL, article_id INT DEFAULT NULL, user_creation_id INT DEFAULT NULL, dossier_id INT DEFAULT NULL, livraisondet_id INT DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, prix_achat DOUBLE PRECISION DEFAULT NULL, prix_vente DOUBLE PRECISION DEFAULT NULL, n_lot VARCHAR(255) DEFAULT NULL, date_exp DATETIME DEFAULT NULL, code_barre VARCHAR(255) DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, date_creation DATETIME NOT NULL, qte DOUBLE PRECISION DEFAULT NULL, conditionnement VARCHAR(255) DEFAULT NULL, code_zone VARCHAR(255) DEFAULT NULL, qte_reste DOUBLE PRECISION DEFAULT NULL, INDEX IDX_7DBB7DA0A52A3FE5 (livraisoncab_id), INDEX IDX_7DBB7DA07294869C (article_id), INDEX IDX_7DBB7DA09DE46F0F (user_creation_id), INDEX IDX_7DBB7DA0611C0C56 (dossier_id), UNIQUE INDEX UNIQ_7DBB7DA038DDA1DE (livraisondet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tdetail_vente (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, opration_vente_id INT DEFAULT NULL, user_create_id INT DEFAULT NULL, dossier_id INT DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, prix_unitaire DOUBLE PRECISION DEFAULT NULL, prix_ttc DOUBLE PRECISION NOT NULL, datetime DATETIME DEFAULT NULL, date_creation DATETIME DEFAULT NULL, quantite DOUBLE PRECISION DEFAULT NULL, INDEX IDX_FB9677EAF347EFB (produit_id), INDEX IDX_FB9677EA6A5C736F (opration_vente_id), INDEX IDX_FB9677EAEEFE5067 (user_create_id), INDEX IDX_FB9677EA611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toperation_vente (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, user_create_id INT DEFAULT NULL, dossier_id INT DEFAULT NULL, date_vente DATETIME DEFAULT NULL, date_creation DATETIME DEFAULT NULL, INDEX IDX_3F924EEF19EB6921 (client_id), INDEX IDX_3F924EEFEEFE5067 (user_create_id), INDEX IDX_3F924EEF611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tstock (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, dossier_id INT DEFAULT NULL, user_create_id INT DEFAULT NULL, livraisoncab_id INT DEFAULT NULL, quantite INT NOT NULL, date_creation DATE DEFAULT NULL, date_modification DATE DEFAULT NULL, INDEX IDX_AC654F097294869C (article_id), INDEX IDX_AC654F09611C0C56 (dossier_id), INDEX IDX_AC654F09EEFE5067 (user_create_id), INDEX IDX_AC654F09A52A3FE5 (livraisoncab_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_affectation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, dossier_id INT DEFAULT NULL, active INT DEFAULT NULL, date_creation DATE DEFAULT NULL, INDEX IDX_5DC6A846A76ED395 (user_id), INDEX IDX_5DC6A846611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vlivraisoncab (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT DEFAULT NULL, client_id INT DEFAULT NULL, user_create_id INT DEFAULT NULL, dossier_id INT DEFAULT NULL, code_livraison VARCHAR(255) DEFAULT NULL, ref_doc_asso VARCHAR(255) DEFAULT NULL, date_livraison DATE DEFAULT NULL, remise VARCHAR(255) DEFAULT NULL, date_remise DATE DEFAULT NULL, mt_remise DOUBLE PRECISION DEFAULT NULL, date_operation DATE DEFAULT NULL, date_creation DATE DEFAULT NULL, id_dossier_ugouv INT DEFAULT NULL, INDEX IDX_EC2FEB58670C757F (fournisseur_id), INDEX IDX_EC2FEB5819EB6921 (client_id), INDEX IDX_EC2FEB58EEFE5067 (user_create_id), INDEX IDX_EC2FEB58611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vlivraisondet (id INT AUTO_INCREMENT NOT NULL, livraisoncab_id INT DEFAULT NULL, user_create_id INT DEFAULT NULL, article LONGTEXT DEFAULT NULL, unite VARCHAR(255) DEFAULT NULL, quantite DOUBLE PRECISION DEFAULT NULL, pri_unitaire DOUBLE PRECISION DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, prix_ttc DOUBLE PRECISION DEFAULT NULL, date_operation DATE DEFAULT NULL, date_creation DATE DEFAULT NULL, id_egouv INT DEFAULT NULL, en_stock INT DEFAULT NULL, INDEX IDX_79D88D88A52A3FE5 (livraisoncab_id), INDEX IDX_79D88D88EEFE5067 (user_create_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE particle ADD CONSTRAINT FK_56249FE1611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE particle ADD CONSTRAINT FK_56249FE1EEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pclient ADD CONSTRAINT FK_782AAA3EEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pclient ADD CONSTRAINT FK_782AAA3611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE pdossier ADD CONSTRAINT FK_695671B0EEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pfornisseur ADD CONSTRAINT FK_B526279FEEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pproduit ADD CONSTRAINT FK_7DBB7DA0A52A3FE5 FOREIGN KEY (livraisoncab_id) REFERENCES vlivraisoncab (id)');
        $this->addSql('ALTER TABLE pproduit ADD CONSTRAINT FK_7DBB7DA07294869C FOREIGN KEY (article_id) REFERENCES particle (id)');
        $this->addSql('ALTER TABLE pproduit ADD CONSTRAINT FK_7DBB7DA09DE46F0F FOREIGN KEY (user_creation_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pproduit ADD CONSTRAINT FK_7DBB7DA0611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE pproduit ADD CONSTRAINT FK_7DBB7DA038DDA1DE FOREIGN KEY (livraisondet_id) REFERENCES vlivraisondet (id)');
        $this->addSql('ALTER TABLE tdetail_vente ADD CONSTRAINT FK_FB9677EAF347EFB FOREIGN KEY (produit_id) REFERENCES pproduit (id)');
        $this->addSql('ALTER TABLE tdetail_vente ADD CONSTRAINT FK_FB9677EA6A5C736F FOREIGN KEY (opration_vente_id) REFERENCES toperation_vente (id)');
        $this->addSql('ALTER TABLE tdetail_vente ADD CONSTRAINT FK_FB9677EAEEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tdetail_vente ADD CONSTRAINT FK_FB9677EA611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE toperation_vente ADD CONSTRAINT FK_3F924EEF19EB6921 FOREIGN KEY (client_id) REFERENCES pclient (id)');
        $this->addSql('ALTER TABLE toperation_vente ADD CONSTRAINT FK_3F924EEFEEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE toperation_vente ADD CONSTRAINT FK_3F924EEF611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE tstock ADD CONSTRAINT FK_AC654F097294869C FOREIGN KEY (article_id) REFERENCES particle (id)');
        $this->addSql('ALTER TABLE tstock ADD CONSTRAINT FK_AC654F09611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE tstock ADD CONSTRAINT FK_AC654F09EEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tstock ADD CONSTRAINT FK_AC654F09A52A3FE5 FOREIGN KEY (livraisoncab_id) REFERENCES vlivraisoncab (id)');
        $this->addSql('ALTER TABLE user_affectation ADD CONSTRAINT FK_5DC6A846A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_affectation ADD CONSTRAINT FK_5DC6A846611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE vlivraisoncab ADD CONSTRAINT FK_EC2FEB58670C757F FOREIGN KEY (fournisseur_id) REFERENCES pfornisseur (id)');
        $this->addSql('ALTER TABLE vlivraisoncab ADD CONSTRAINT FK_EC2FEB5819EB6921 FOREIGN KEY (client_id) REFERENCES pclient (id)');
        $this->addSql('ALTER TABLE vlivraisoncab ADD CONSTRAINT FK_EC2FEB58EEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vlivraisoncab ADD CONSTRAINT FK_EC2FEB58611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE vlivraisondet ADD CONSTRAINT FK_79D88D88A52A3FE5 FOREIGN KEY (livraisoncab_id) REFERENCES vlivraisoncab (id)');
        $this->addSql('ALTER TABLE vlivraisondet ADD CONSTRAINT FK_79D88D88EEFE5067 FOREIGN KEY (user_create_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pproduit DROP FOREIGN KEY FK_7DBB7DA07294869C');
        $this->addSql('ALTER TABLE tstock DROP FOREIGN KEY FK_AC654F097294869C');
        $this->addSql('ALTER TABLE toperation_vente DROP FOREIGN KEY FK_3F924EEF19EB6921');
        $this->addSql('ALTER TABLE vlivraisoncab DROP FOREIGN KEY FK_EC2FEB5819EB6921');
        $this->addSql('ALTER TABLE particle DROP FOREIGN KEY FK_56249FE1611C0C56');
        $this->addSql('ALTER TABLE pclient DROP FOREIGN KEY FK_782AAA3611C0C56');
        $this->addSql('ALTER TABLE pproduit DROP FOREIGN KEY FK_7DBB7DA0611C0C56');
        $this->addSql('ALTER TABLE tdetail_vente DROP FOREIGN KEY FK_FB9677EA611C0C56');
        $this->addSql('ALTER TABLE toperation_vente DROP FOREIGN KEY FK_3F924EEF611C0C56');
        $this->addSql('ALTER TABLE tstock DROP FOREIGN KEY FK_AC654F09611C0C56');
        $this->addSql('ALTER TABLE user_affectation DROP FOREIGN KEY FK_5DC6A846611C0C56');
        $this->addSql('ALTER TABLE vlivraisoncab DROP FOREIGN KEY FK_EC2FEB58611C0C56');
        $this->addSql('ALTER TABLE vlivraisoncab DROP FOREIGN KEY FK_EC2FEB58670C757F');
        $this->addSql('ALTER TABLE tdetail_vente DROP FOREIGN KEY FK_FB9677EAF347EFB');
        $this->addSql('ALTER TABLE tdetail_vente DROP FOREIGN KEY FK_FB9677EA6A5C736F');
        $this->addSql('ALTER TABLE particle DROP FOREIGN KEY FK_56249FE1EEFE5067');
        $this->addSql('ALTER TABLE pclient DROP FOREIGN KEY FK_782AAA3EEFE5067');
        $this->addSql('ALTER TABLE pdossier DROP FOREIGN KEY FK_695671B0EEFE5067');
        $this->addSql('ALTER TABLE pfornisseur DROP FOREIGN KEY FK_B526279FEEFE5067');
        $this->addSql('ALTER TABLE pproduit DROP FOREIGN KEY FK_7DBB7DA09DE46F0F');
        $this->addSql('ALTER TABLE tdetail_vente DROP FOREIGN KEY FK_FB9677EAEEFE5067');
        $this->addSql('ALTER TABLE toperation_vente DROP FOREIGN KEY FK_3F924EEFEEFE5067');
        $this->addSql('ALTER TABLE tstock DROP FOREIGN KEY FK_AC654F09EEFE5067');
        $this->addSql('ALTER TABLE user_affectation DROP FOREIGN KEY FK_5DC6A846A76ED395');
        $this->addSql('ALTER TABLE vlivraisoncab DROP FOREIGN KEY FK_EC2FEB58EEFE5067');
        $this->addSql('ALTER TABLE vlivraisondet DROP FOREIGN KEY FK_79D88D88EEFE5067');
        $this->addSql('ALTER TABLE pproduit DROP FOREIGN KEY FK_7DBB7DA0A52A3FE5');
        $this->addSql('ALTER TABLE tstock DROP FOREIGN KEY FK_AC654F09A52A3FE5');
        $this->addSql('ALTER TABLE vlivraisondet DROP FOREIGN KEY FK_79D88D88A52A3FE5');
        $this->addSql('ALTER TABLE pproduit DROP FOREIGN KEY FK_7DBB7DA038DDA1DE');
        $this->addSql('DROP TABLE particle');
        $this->addSql('DROP TABLE pclient');
        $this->addSql('DROP TABLE pdossier');
        $this->addSql('DROP TABLE pfornisseur');
        $this->addSql('DROP TABLE pproduit');
        $this->addSql('DROP TABLE tdetail_vente');
        $this->addSql('DROP TABLE toperation_vente');
        $this->addSql('DROP TABLE tstock');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_affectation');
        $this->addSql('DROP TABLE vlivraisoncab');
        $this->addSql('DROP TABLE vlivraisondet');
    }
}
