<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331174718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_api_item (id INT AUTO_INCREMENT NOT NULL, uid INT NOT NULL, name VARCHAR(255) NOT NULL, text LONGTEXT DEFAULT NULL, type VARCHAR(55) NOT NULL, subtype VARCHAR(55) DEFAULT NULL, rarity VARCHAR(25) NOT NULL, blackmarket TINYINT(1) DEFAULT NULL, data JSON NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_6A2554BE539B0606 (uid), UNIQUE INDEX UNIQ_6A2554BE989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE gw2_api_item');
    }
}
