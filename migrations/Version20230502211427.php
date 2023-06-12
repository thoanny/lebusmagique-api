<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502211427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_api_item ADD fish_bait_item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gw2_api_item ADD CONSTRAINT FK_6A2554BEA9D03B2A FOREIGN KEY (fish_bait_item_id) REFERENCES gw2_api_item (id)');
        $this->addSql('CREATE INDEX IDX_6A2554BEA9D03B2A ON gw2_api_item (fish_bait_item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_api_item DROP FOREIGN KEY FK_6A2554BEA9D03B2A');
        $this->addSql('DROP INDEX IDX_6A2554BEA9D03B2A ON gw2_api_item');
        $this->addSql('ALTER TABLE gw2_api_item DROP fish_bait_item_id');
    }
}
