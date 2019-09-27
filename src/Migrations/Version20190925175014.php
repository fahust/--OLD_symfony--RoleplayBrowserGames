<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190925175014 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE monster_user ADD updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, ADD image_file VARCHAR(255) DEFAULT NULL, ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE objet ADD type VARCHAR(255) DEFAULT NULL, ADD language VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD type VARCHAR(255) DEFAULT NULL, ADD language VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE quest_variable ADD type VARCHAR(255) DEFAULT NULL, ADD language VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD type VARCHAR(255) DEFAULT NULL, ADD language VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE monster_user DROP updated_at, DROP image_file, DROP image_name');
        $this->addSql('ALTER TABLE objet DROP type, DROP language');
        $this->addSql('ALTER TABLE player DROP type, DROP language');
        $this->addSql('ALTER TABLE quest_variable DROP type, DROP language');
        $this->addSql('ALTER TABLE skill DROP type, DROP language');
    }
}
