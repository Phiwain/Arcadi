<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114135527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_update (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, date DATE NOT NULL, time TIME NOT NULL, quantite_nourriture DOUBLE PRECISION DEFAULT NULL, nourriture VARCHAR(255) DEFAULT NULL, INDEX IDX_22D4F0A48E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_update ADD CONSTRAINT FK_22D4F0A48E962C16 FOREIGN KEY (animal_id) REFERENCES amnial (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_update DROP FOREIGN KEY FK_22D4F0A48E962C16');
        $this->addSql('DROP TABLE animal_update');
    }
}
