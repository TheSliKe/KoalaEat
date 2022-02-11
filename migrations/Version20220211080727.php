<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211080727 extends AbstractMigration
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
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, fk_vi_id INT DEFAULT NULL, fk_us_id INT NOT NULL, cl_nom VARCHAR(255) DEFAULT NULL, cl_prenom VARCHAR(255) DEFAULT NULL, cl_telephone INT DEFAULT NULL, cl_mail VARCHAR(255) NOT NULL, cl_adresse VARCHAR(255) DEFAULT NULL, INDEX IDX_C7440455AE7365AC (fk_vi_id), INDEX IDX_C7440455D677A887 (fk_us_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, fk_li_id INT DEFAULT NULL, fk_cl_id INT NOT NULL, fk_restaurant_id INT DEFAULT NULL, co_adresse_de_livraison VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67D8423EA8F (fk_li_id), INDEX IDX_6EEAA67D31AD8D6C (fk_cl_id), INDEX IDX_6EEAA67DD5AD05AC (fk_restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compose (id INT AUTO_INCREMENT NOT NULL, fk_pa_id INT NOT NULL, fk_co_id INT DEFAULT NULL, co_quantite INT NOT NULL, INDEX IDX_AE4C1416E487B8E3 (fk_pa_id), INDEX IDX_AE4C141623182282 (fk_co_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire_restaurant (id INT AUTO_INCREMENT NOT NULL, fk_re_id INT NOT NULL, fk_sem_id INT DEFAULT NULL, horaire_debut_midi VARCHAR(255) DEFAULT NULL, horaire_fin_midi VARCHAR(255) DEFAULT NULL, horaire_debut_soir VARCHAR(255) DEFAULT NULL, horaire_fin_soir VARCHAR(255) DEFAULT NULL, INDEX IDX_2A6E34AE11257CD4 (fk_re_id), INDEX IDX_2A6E34AE1D447D9D (fk_sem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, fk_vi_id INT DEFAULT NULL, fk_us_id INT NOT NULL, li_nom VARCHAR(255) DEFAULT NULL, li_prenom VARCHAR(255) DEFAULT NULL, li_telephone INT DEFAULT NULL, li_mail VARCHAR(255) NOT NULL, INDEX IDX_EB7A4E6DAE7365AC (fk_vi_id), INDEX IDX_EB7A4E6DD677A887 (fk_us_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, fk_re_id INT DEFAULT NULL, pa_libelle VARCHAR(255) NOT NULL, pa_prix INT NOT NULL, pa_stock INT NOT NULL, est_supprime TINYINT(1) DEFAULT NULL, INDEX IDX_2038A20711257CD4 (fk_re_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE possede (id INT AUTO_INCREMENT NOT NULL, fk_st_id INT DEFAULT NULL, fk_co_id INT DEFAULT NULL, po_date DATETIME NOT NULL, INDEX IDX_3D0B1508C4E0659E (fk_st_id), INDEX IDX_3D0B150823182282 (fk_co_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, fk_res_id_id INT NOT NULL, fk_vi_id_id INT DEFAULT NULL, re_libelle VARCHAR(255) NOT NULL, re_adresse VARCHAR(255) NOT NULL, INDEX IDX_EB95123F58309F6C (fk_res_id_id), INDEX IDX_EB95123F67A5DEFE (fk_vi_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurateur (id INT AUTO_INCREMENT NOT NULL, fk_us_id INT NOT NULL, res_nom VARCHAR(255) DEFAULT NULL, res_prenom VARCHAR(255) DEFAULT NULL, res_telephone INT DEFAULT NULL, res_mail VARCHAR(255) NOT NULL, res_adresse VARCHAR(255) DEFAULT NULL, INDEX IDX_24BD4101D677A887 (fk_us_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, se_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semaine (id INT AUTO_INCREMENT NOT NULL, sem_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, st_libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, account_type INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, fk_li_id INT DEFAULT NULL, ve_libelle VARCHAR(255) NOT NULL, ve_immatriculation VARCHAR(255) DEFAULT NULL, INDEX IDX_292FFF1D8423EA8F (fk_li_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, fk_se_id_id INT NOT NULL, vi_libelle VARCHAR(255) NOT NULL, INDEX IDX_43C3D9C3E8E5BAEE (fk_se_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_restaurant ADD CONSTRAINT FK_4A1B5237A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_restaurant ADD CONSTRAINT FK_4A1B5237B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455AE7365AC FOREIGN KEY (fk_vi_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455D677A887 FOREIGN KEY (fk_us_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8423EA8F FOREIGN KEY (fk_li_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D31AD8D6C FOREIGN KEY (fk_cl_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DD5AD05AC FOREIGN KEY (fk_restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE compose ADD CONSTRAINT FK_AE4C1416E487B8E3 FOREIGN KEY (fk_pa_id) REFERENCES plat (id)');
        $this->addSql('ALTER TABLE compose ADD CONSTRAINT FK_AE4C141623182282 FOREIGN KEY (fk_co_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE horaire_restaurant ADD CONSTRAINT FK_2A6E34AE11257CD4 FOREIGN KEY (fk_re_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE horaire_restaurant ADD CONSTRAINT FK_2A6E34AE1D447D9D FOREIGN KEY (fk_sem_id) REFERENCES semaine (id)');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6DAE7365AC FOREIGN KEY (fk_vi_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6DD677A887 FOREIGN KEY (fk_us_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A20711257CD4 FOREIGN KEY (fk_re_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE possede ADD CONSTRAINT FK_3D0B1508C4E0659E FOREIGN KEY (fk_st_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE possede ADD CONSTRAINT FK_3D0B150823182282 FOREIGN KEY (fk_co_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F58309F6C FOREIGN KEY (fk_res_id_id) REFERENCES restaurateur (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F67A5DEFE FOREIGN KEY (fk_vi_id_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE restaurateur ADD CONSTRAINT FK_24BD4101D677A887 FOREIGN KEY (fk_us_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D8423EA8F FOREIGN KEY (fk_li_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3E8E5BAEE FOREIGN KEY (fk_se_id_id) REFERENCES secteur (id)');

        $this->addSql('INSERT INTO status (id, st_libelle) VALUES 
            (1,"En attente"),
            (2,"Accepté par le restaurant"),
            (3,"Prise en charge par le livreur"),
            (4,"Preparation"),
            (5,"Prête à être expédié"),
            (6,"En cours de livraison"),
            (7,"Livrée")
        ');

        $this->addSql('INSERT INTO semaine (id, sem_libelle) VALUES 
            (1,"lundi"),
            (2,"mardi"),
            (3,"mercredi"),
            (4,"jeudi"),
            (5,"vendredi"),
            (6,"samedi"),
            (7,"dimanche")
        ');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_restaurant DROP FOREIGN KEY FK_4A1B5237A21214B7');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D31AD8D6C');
        $this->addSql('ALTER TABLE compose DROP FOREIGN KEY FK_AE4C141623182282');
        $this->addSql('ALTER TABLE possede DROP FOREIGN KEY FK_3D0B150823182282');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D8423EA8F');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D8423EA8F');
        $this->addSql('ALTER TABLE compose DROP FOREIGN KEY FK_AE4C1416E487B8E3');
        $this->addSql('ALTER TABLE categories_restaurant DROP FOREIGN KEY FK_4A1B5237B1E7706E');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DD5AD05AC');
        $this->addSql('ALTER TABLE horaire_restaurant DROP FOREIGN KEY FK_2A6E34AE11257CD4');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A20711257CD4');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F58309F6C');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3E8E5BAEE');
        $this->addSql('ALTER TABLE horaire_restaurant DROP FOREIGN KEY FK_2A6E34AE1D447D9D');
        $this->addSql('ALTER TABLE possede DROP FOREIGN KEY FK_3D0B1508C4E0659E');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455D677A887');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6DD677A887');
        $this->addSql('ALTER TABLE restaurateur DROP FOREIGN KEY FK_24BD4101D677A887');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455AE7365AC');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6DAE7365AC');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F67A5DEFE');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_restaurant');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE compose');
        $this->addSql('DROP TABLE horaire_restaurant');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE possede');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE restaurateur');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE semaine');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP TABLE ville');
    }
}
