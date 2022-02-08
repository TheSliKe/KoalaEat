<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208151015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD fk_us_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455D677A887 FOREIGN KEY (fk_us_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_C7440455D677A887 ON client (fk_us_id)');
        $this->addSql('ALTER TABLE livreur ADD fk_us_id INT NOT NULL');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6DD677A887 FOREIGN KEY (fk_us_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_EB7A4E6DD677A887 ON livreur (fk_us_id)');
        $this->addSql('ALTER TABLE restaurateur ADD fk_us_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurateur ADD CONSTRAINT FK_24BD4101D677A887 FOREIGN KEY (fk_us_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_24BD4101D677A887 ON restaurateur (fk_us_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories CHANGE ca_libelle ca_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455D677A887');
        $this->addSql('DROP INDEX IDX_C7440455D677A887 ON client');
        $this->addSql('ALTER TABLE client DROP fk_us_id, CHANGE cl_nom cl_nom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cl_prenom cl_prenom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cl_mail cl_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cl_adresse cl_adresse VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commande CHANGE co_adresse_de_livraison co_adresse_de_livraison VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6DD677A887');
        $this->addSql('DROP INDEX IDX_EB7A4E6DD677A887 ON livreur');
        $this->addSql('ALTER TABLE livreur DROP fk_us_id, CHANGE li_nom li_nom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE li_prenom li_prenom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE li_mail li_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE plat CHANGE pa_libelle pa_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurant CHANGE re_libelle re_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE re_adresse re_adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurateur DROP FOREIGN KEY FK_24BD4101D677A887');
        $this->addSql('DROP INDEX IDX_24BD4101D677A887 ON restaurateur');
        $this->addSql('ALTER TABLE restaurateur DROP fk_us_id, CHANGE res_nom res_nom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_prenom res_prenom VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_mail res_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_adresse res_adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE secteur CHANGE se_libelle se_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE semaine CHANGE sem_libelle sem_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE status CHANGE st_libelle st_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE vehicule CHANGE ve_libelle ve_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ve_immatriculation ve_immatriculation VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ville CHANGE vi_libelle vi_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
