<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429092336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item_item_tag (item_id INT NOT NULL, item_tag_id INT NOT NULL, INDEX IDX_8891047A126F525E (item_id), INDEX IDX_8891047A3C2B16DE (item_tag_id), PRIMARY KEY(item_id, item_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_api_item_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_item_tag ADD CONSTRAINT FK_8891047A126F525E FOREIGN KEY (item_id) REFERENCES gw2_api_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_item_tag ADD CONSTRAINT FK_8891047A3C2B16DE FOREIGN KEY (item_tag_id) REFERENCES gw2_api_item_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gw2_api_item ADD inventory_manager_tip LONGTEXT DEFAULT NULL, ADD obtening_tip LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_item_tag DROP FOREIGN KEY FK_8891047A126F525E');
        $this->addSql('ALTER TABLE item_item_tag DROP FOREIGN KEY FK_8891047A3C2B16DE');
        $this->addSql('DROP TABLE item_item_tag');
        $this->addSql('DROP TABLE gw2_api_item_tag');
        $this->addSql('ALTER TABLE gw2_api_item DROP inventory_manager_tip, DROP obtening_tip');
    }
}
