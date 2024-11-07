<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107130628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amnial (id INT AUTO_INCREMENT NOT NULL, race_id INT DEFAULT NULL, habitat_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, INDEX IDX_B7D5C9AA6E59D40D (race_id), INDEX IDX_B7D5C9AAAFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_race (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amnial ADD CONSTRAINT FK_B7D5C9AA6E59D40D FOREIGN KEY (race_id) REFERENCES animal_race (id)');
        $this->addSql('ALTER TABLE amnial ADD CONSTRAINT FK_B7D5C9AAAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE amnial DROP FOREIGN KEY FK_B7D5C9AA6E59D40D');
        $this->addSql('ALTER TABLE amnial DROP FOREIGN KEY FK_B7D5C9AAAFFE2D26');
        $this->addSql('DROP TABLE amnial');
        $this->addSql('DROP TABLE animal_race');
    }
}
