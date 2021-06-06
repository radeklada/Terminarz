<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210601170714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts ADD user_id INT UNSIGNED DEFAULT NULL, CHANGE last_name last_name VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_33401573A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX contacts_user_id_idx ON contacts (user_id)');
        $this->addSql('ALTER TABLE events ADD user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX events_user_id_idx ON events (user_id)');
        $this->addSql('ALTER TABLE user_info ADD user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX user_info_user_id_idx ON user_info (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573A76ED395');
        $this->addSql('DROP INDEX contacts_user_id_idx ON contacts');
        $this->addSql('ALTER TABLE contacts DROP user_id, CHANGE last_name last_name VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AA76ED395');
        $this->addSql('DROP INDEX events_user_id_idx ON events');
        $this->addSql('ALTER TABLE events DROP user_id');
        $this->addSql('ALTER TABLE user_info DROP FOREIGN KEY FK_B1087D9EA76ED395');
        $this->addSql('DROP INDEX user_info_user_id_idx ON user_info');
        $this->addSql('ALTER TABLE user_info DROP user_id');
    }
}
