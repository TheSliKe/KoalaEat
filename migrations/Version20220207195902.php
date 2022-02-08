<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207195902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, se_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, fk_se_id_id INT NOT NULL, vi_libelle VARCHAR(255) NOT NULL, INDEX IDX_43C3D9C3E8E5BAEE (fk_se_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3E8E5BAEE FOREIGN KEY (fk_se_id_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE restaurant ADD fk_vi_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F67A5DEFE FOREIGN KEY (fk_vi_id_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_EB95123F67A5DEFE ON restaurant (fk_vi_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3E8E5BAEE');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F67A5DEFE');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP INDEX IDX_EB95123F67A5DEFE ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP fk_vi_id_id, CHANGE re_libelle re_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE re_adresse re_adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurateur CHANGE res_nom res_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_prenom res_prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_mail res_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
