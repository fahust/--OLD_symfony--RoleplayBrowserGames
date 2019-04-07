<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190324223101 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quest_variable DROP FOREIGN KEY FK_2D1738288988EF57');
        $this->addSql('DROP INDEX UNIQ_2D1738288988EF57 ON quest_variable');
        $this->addSql('ALTER TABLE quest_variable CHANGE objetrequismany_id questrequismany_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quest_variable ADD CONSTRAINT FK_2D17382861B76877 FOREIGN KEY (questrequismany_id) REFERENCES objet (id)');
        $this->addSql('CREATE INDEX IDX_2D17382861B76877 ON quest_variable (questrequismany_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quest_variable DROP FOREIGN KEY FK_2D17382861B76877');
        $this->addSql('DROP INDEX IDX_2D17382861B76877 ON quest_variable');
        $this->addSql('ALTER TABLE quest_variable CHANGE questrequismany_id objetrequismany_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quest_variable ADD CONSTRAINT FK_2D1738288988EF57 FOREIGN KEY (objetrequismany_id) REFERENCES objet (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D1738288988EF57 ON quest_variable (objetrequismany_id)');
    }
}
