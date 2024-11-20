<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119155210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amnial (id INT AUTO_INCREMENT NOT NULL, race_id INT DEFAULT NULL, habitat_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, poids DOUBLE PRECISION NOT NULL, INDEX IDX_B7D5C9AA6E59D40D (race_id), INDEX IDX_B7D5C9AAAFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_race (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_update (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, date DATE NOT NULL, time TIME NOT NULL, quantite_nourriture DOUBLE PRECISION DEFAULT NULL, nourriture VARCHAR(255) DEFAULT NULL, INDEX IDX_22D4F0A48E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, commentaire VARCHAR(255) NOT NULL, note DOUBLE PRECISION NOT NULL, is_published TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitats (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitats_update (id INT AUTO_INCREMENT NOT NULL, habitat_id INT DEFAULT NULL, avis VARCHAR(255) NOT NULL, amelioration VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_93D69A40AFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ouvertures (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(255) NOT NULL, open_morning DOUBLE PRECISION NOT NULL, closed_morning DOUBLE PRECISION DEFAULT NULL, open_evening DOUBLE PRECISION DEFAULT NULL, closed_evening DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapports (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, etat VARCHAR(255) NOT NULL, nourriture VARCHAR(255) NOT NULL, poids_nourriture DOUBLE PRECISION NOT NULL, date_passage DATE NOT NULL, detail VARCHAR(255) DEFAULT NULL, poids DOUBLE PRECISION NOT NULL, INDEX IDX_E20924C48E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, descrition VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, descriptionhome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amnial ADD CONSTRAINT FK_B7D5C9AA6E59D40D FOREIGN KEY (race_id) REFERENCES animal_race (id)');
        $this->addSql('ALTER TABLE amnial ADD CONSTRAINT FK_B7D5C9AAAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE animal_update ADD CONSTRAINT FK_22D4F0A48E962C16 FOREIGN KEY (animal_id) REFERENCES amnial (id)');
        $this->addSql('ALTER TABLE habitats_update ADD CONSTRAINT FK_93D69A40AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE rapports ADD CONSTRAINT FK_E20924C48E962C16 FOREIGN KEY (animal_id) REFERENCES amnial (id)');
        $hashedPassword = password_hash('Admin123456!', PASSWORD_BCRYPT);

        // Insert a new Employee record with the hashed password
        $this->addSql("INSERT INTO user (password, email, roles ,nom, prenom) VALUES ('admin@zooarcadia.fr', '[\"ROLE_ADMIN\"]', '$hashedPassword', 'Admin', 'User')");
        $this->addSql("INSERT INTO user (password, email, roles ,nom, prenom) VALUES ('employee@zooarcadia.fr', '[\"ROLE_ADMIN\"]', '$hashedPassword', 'employee', 'User')");
        $this->addSql("INSERT INTO user (password, email, roles ,nom, prenom) VALUES ('veterinaire@zooarcadia.fr', '[\"ROLE_ADMIN\"]', '$hashedPassword', 'veterinaire', 'User')");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amnial DROP FOREIGN KEY FK_B7D5C9AA6E59D40D');
        $this->addSql('ALTER TABLE amnial DROP FOREIGN KEY FK_B7D5C9AAAFFE2D26');
        $this->addSql('ALTER TABLE animal_update DROP FOREIGN KEY FK_22D4F0A48E962C16');
        $this->addSql('ALTER TABLE habitats_update DROP FOREIGN KEY FK_93D69A40AFFE2D26');
        $this->addSql('ALTER TABLE rapports DROP FOREIGN KEY FK_E20924C48E962C16');
        $this->addSql('DROP TABLE amnial');
        $this->addSql('DROP TABLE animal_race');
        $this->addSql('DROP TABLE animal_update');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE habitats');
        $this->addSql('DROP TABLE habitats_update');
        $this->addSql('DROP TABLE ouvertures');
        $this->addSql('DROP TABLE rapports');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visite');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
