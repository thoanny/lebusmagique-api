<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231006153719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_fish_daily (id INT AUTO_INCREMENT NOT NULL, fish_id INT NOT NULL, day DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_EFA096E78311A1E2 (fish_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gw2_fish_daily ADD CONSTRAINT FK_EFA096E78311A1E2 FOREIGN KEY (fish_id) REFERENCES gw2_api_item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_fish_daily DROP FOREIGN KEY FK_EFA096E78311A1E2');
        $this->addSql('DROP TABLE gw2_fish_daily');
    }
}
