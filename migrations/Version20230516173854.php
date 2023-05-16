<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516173854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_api_item_price (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, buys_quantity INT NOT NULL, buys_unit_price INT NOT NULL, sells_quantity INT NOT NULL, sells_unit_price INT NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', checksum VARCHAR(55) NOT NULL, UNIQUE INDEX UNIQ_7F0FC4B1126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gw2_api_item_price ADD CONSTRAINT FK_7F0FC4B1126F525E FOREIGN KEY (item_id) REFERENCES gw2_api_item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_api_item_price DROP FOREIGN KEY FK_7F0FC4B1126F525E');
        $this->addSql('DROP TABLE gw2_api_item_price');
    }
}
