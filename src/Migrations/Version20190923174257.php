<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190923174257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE monster ADD maxhp INT NOT NULL, ADD maxatk INT NOT NULL, ADD maxesq INT NOT NULL, ADD maxdef INT NOT NULL, ADD maxdgt INT NOT NULL, ADD created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE monster_user ADD maxhp INT NOT NULL, ADD maxatk INT NOT NULL, ADD maxesq INT NOT NULL, ADD maxdef INT NOT NULL, ADD maxdgt INT NOT NULL');
        $this->addSql('ALTER TABLE objet ADD created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE player ADD mana INT NOT NULL, ADD esq INT NOT NULL, ADD def INT NOT NULL, ADD maxatk INT NOT NULL, ADD maxesq INT NOT NULL, ADD maxdef INT NOT NULL, ADD maxmana INT NOT NULL');
        $this->addSql('ALTER TABLE quest_variable ADD created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE skill ADD destinataire TINYINT(1) NOT NULL, ADD created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, CHANGE updated_at updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE user ADD constructpnt INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE monster DROP maxhp, DROP maxatk, DROP maxesq, DROP maxdef, DROP maxdgt, DROP created_at');
        $this->addSql('ALTER TABLE monster_user DROP maxhp, DROP maxatk, DROP maxesq, DROP maxdef, DROP maxdgt');
        $this->addSql('ALTER TABLE objet DROP created_at');
        $this->addSql('ALTER TABLE player DROP mana, DROP esq, DROP def, DROP maxatk, DROP maxesq, DROP maxdef, DROP maxmana');
        $this->addSql('ALTER TABLE quest_variable DROP created_at');
        $this->addSql('ALTER TABLE skill DROP destinataire, DROP created_at, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE user DROP constructpnt');
    }
}
