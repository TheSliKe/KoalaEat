<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208110718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, fk_vi_id INT DEFAULT NULL, cl_nom VARCHAR(255) NOT NULL, cl_prenom VARCHAR(255) NOT NULL, cl_telephone INT NOT NULL, cl_mail VARCHAR(255) NOT NULL, cl_adresse VARCHAR(255) NOT NULL, INDEX IDX_C7440455AE7365AC (fk_vi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455AE7365AC FOREIGN KEY (fk_vi_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE commande ADD fk_li_id INT DEFAULT NULL, ADD fk_cl_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8423EA8F FOREIGN KEY (fk_li_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D31AD8D6C FOREIGN KEY (fk_cl_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D8423EA8F ON commande (fk_li_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D31AD8D6C ON commande (fk_cl_id)');
        $this->addSql('ALTER TABLE livreur ADD fk_vi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6DAE7365AC FOREIGN KEY (fk_vi_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_EB7A4E6DAE7365AC ON livreur (fk_vi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D31AD8D6C');
        $this->addSql('DROP TABLE client');
        $this->addSql('ALTER TABLE categories CHANGE ca_libelle ca_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D8423EA8F');
        $this->addSql('DROP INDEX IDX_6EEAA67D8423EA8F ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67D31AD8D6C ON commande');
        $this->addSql('ALTER TABLE commande DROP fk_li_id, DROP fk_cl_id, CHANGE co_adresse_de_livraison co_adresse_de_livraison VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6DAE7365AC');
        $this->addSql('DROP INDEX IDX_EB7A4E6DAE7365AC ON livreur');
        $this->addSql('ALTER TABLE livreur DROP fk_vi_id, CHANGE li_nom li_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE li_prenom li_prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE li_mail li_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE plat CHANGE pa_libelle pa_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurant CHANGE re_libelle re_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE re_adresse re_adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurateur CHANGE res_nom res_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_prenom res_prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_mail res_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE secteur CHANGE se_libelle se_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE status CHANGE st_libelle st_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles JSON NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE vehicule CHANGE ve_libelle ve_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ve_immatriculation ve_immatriculation VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ville CHANGE vi_libelle vi_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
