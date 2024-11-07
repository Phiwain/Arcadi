<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107135046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapports ADD animal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapports ADD CONSTRAINT FK_E20924C48E962C16 FOREIGN KEY (animal_id) REFERENCES amnial (id)');
        $this->addSql('CREATE INDEX IDX_E20924C48E962C16 ON rapports (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapports DROP FOREIGN KEY FK_E20924C48E962C16');
        $this->addSql('DROP INDEX IDX_E20924C48E962C16 ON rapports');
        $this->addSql('ALTER TABLE rapports DROP animal_id');
    }
}
