<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190324192724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest_variable_objet (quest_variable_id INT NOT NULL, objet_id INT NOT NULL, INDEX IDX_4B006E2DC453EB79 (quest_variable_id), INDEX IDX_4B006E2DF520CF5A (objet_id), PRIMARY KEY(quest_variable_id, objet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_objet (user_id INT NOT NULL, objet_id INT NOT NULL, INDEX IDX_A40FB760A76ED395 (user_id), INDEX IDX_A40FB760F520CF5A (objet_id), PRIMARY KEY(user_id, objet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quest_variable_objet ADD CONSTRAINT FK_4B006E2DC453EB79 FOREIGN KEY (quest_variable_id) REFERENCES quest_variable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quest_variable_objet ADD CONSTRAINT FK_4B006E2DF520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_objet ADD CONSTRAINT FK_A40FB760A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_objet ADD CONSTRAINT FK_A40FB760F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quest_variable ADD objetrequis INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quest_variable_objet DROP FOREIGN KEY FK_4B006E2DF520CF5A');
        $this->addSql('ALTER TABLE user_objet DROP FOREIGN KEY FK_A40FB760F520CF5A');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE quest_variable_objet');
        $this->addSql('DROP TABLE user_objet');
        $this->addSql('ALTER TABLE quest_variable DROP objetrequis');
    }
}
