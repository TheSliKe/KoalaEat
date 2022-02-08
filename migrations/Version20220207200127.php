<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207200127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, ca_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories_restaurant (categories_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_4A1B5237A21214B7 (categories_id), INDEX IDX_4A1B5237B1E7706E (restaurant_id), PRIMARY KEY(categories_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_restaurant ADD CONSTRAINT FK_4A1B5237A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_restaurant ADD CONSTRAINT FK_4A1B5237B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_restaurant DROP FOREIGN KEY FK_4A1B5237A21214B7');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_restaurant');
        $this->addSql('ALTER TABLE restaurant CHANGE re_libelle re_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE re_adresse re_adresse VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restaurateur CHANGE res_nom res_nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_prenom res_prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_mail res_mail VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE secteur CHANGE se_libelle se_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ville CHANGE vi_libelle vi_libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
