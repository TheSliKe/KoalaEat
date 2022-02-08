<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208101016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, li_nom VARCHAR(255) NOT NULL, li_prenom VARCHAR(255) NOT NULL, li_telephone INT NOT NULL, li_mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, fk_li_id INT DEFAULT NULL, ve_libelle VARCHAR(255) NOT NULL, ve_immatriculation VARCHAR(255) DEFAULT NULL, INDEX IDX_292FFF1D8423EA8F (fk_li_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D8423EA8F FOREIGN KEY (fk_li_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F58309F6C');
        $this->addSql('DROP INDEX IDX_EB95123F58309F6C ON restaurant');
        $this->addSql('ALTER TABLE restaurant CHANGE fk_res_id fk_res_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F58309F6C FOREIGN KEY (fk_res_id_id) REFERENCES restaurateur (id)');
        $this->addSql('CREATE INDEX IDX_EB95123F58309F6C ON restaurant (fk_res_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D8423EA8F');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('ALTER TABLE categories CHANGE ca_libelle ca_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commande CHANGE co_adresse_de_livraison co_adresse_de_livraison VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE plat CHANGE pa_libelle pa_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F58309F6C');
        $this->addSql('DROP INDEX IDX_EB95123F58309F6C ON restaurant');
        $this->addSql('ALTER TABLE restaurant CHANGE re_libelle re_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE re_adresse re_adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE fk_res_id_id fk_res_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F58309F6C FOREIGN KEY (fk_res_id) REFERENCES restaurateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EB95123F58309F6C ON restaurant (fk_res_id)');
        $this->addSql('ALTER TABLE restaurateur CHANGE res_nom res_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_prenom res_prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_mail res_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE secteur CHANGE se_libelle se_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE status CHANGE st_libelle st_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles JSON NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ville CHANGE vi_libelle vi_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
