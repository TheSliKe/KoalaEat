<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208074654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compose (id INT AUTO_INCREMENT NOT NULL, fk_pa_id INT NOT NULL, fk_co_id INT DEFAULT NULL, co_quantite INT NOT NULL, INDEX IDX_AE4C1416E487B8E3 (fk_pa_id), INDEX IDX_AE4C141623182282 (fk_co_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compose ADD CONSTRAINT FK_AE4C1416E487B8E3 FOREIGN KEY (fk_pa_id) REFERENCES plat (id)');
        $this->addSql('ALTER TABLE compose ADD CONSTRAINT FK_AE4C141623182282 FOREIGN KEY (fk_co_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE compose');
        $this->addSql('ALTER TABLE categories CHANGE ca_libelle ca_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commande CHANGE co_adresse_de_livraison co_adresse_de_livraison VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE plat CHANGE pa_libelle pa_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurant CHANGE re_libelle re_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE re_adresse re_adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurateur CHANGE res_nom res_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_prenom res_prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_mail res_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE secteur CHANGE se_libelle se_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE status CHANGE st_libelle st_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ville CHANGE vi_libelle vi_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
