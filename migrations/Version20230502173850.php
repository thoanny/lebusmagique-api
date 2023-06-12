<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502173850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_fish_achievement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, achievement_id INT NOT NULL, achievement_repeat_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_fish_hole (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_fish_map (id INT AUTO_INCREMENT NOT NULL, fish_achievement_id INT NOT NULL, name VARCHAR(55) NOT NULL, map_id INT NOT NULL, INDEX IDX_E237578EF6AAC854 (fish_achievement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gw2_fish_map ADD CONSTRAINT FK_E237578EF6AAC854 FOREIGN KEY (fish_achievement_id) REFERENCES gw2_fish_achievement (id)');
        $this->addSql('ALTER TABLE gw2_api_item ADD fish_achievement_id INT DEFAULT NULL, ADD fish_hole_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gw2_api_item ADD CONSTRAINT FK_6A2554BEF6AAC854 FOREIGN KEY (fish_achievement_id) REFERENCES gw2_fish_achievement (id)');
        $this->addSql('ALTER TABLE gw2_api_item ADD CONSTRAINT FK_6A2554BE69216525 FOREIGN KEY (fish_hole_id) REFERENCES gw2_fish_hole (id)');
        $this->addSql('CREATE INDEX IDX_6A2554BEF6AAC854 ON gw2_api_item (fish_achievement_id)');
        $this->addSql('CREATE INDEX IDX_6A2554BE69216525 ON gw2_api_item (fish_hole_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_api_item DROP FOREIGN KEY FK_6A2554BEF6AAC854');
        $this->addSql('ALTER TABLE gw2_api_item DROP FOREIGN KEY FK_6A2554BE69216525');
        $this->addSql('ALTER TABLE gw2_fish_map DROP FOREIGN KEY FK_E237578EF6AAC854');
        $this->addSql('DROP TABLE gw2_fish_achievement');
        $this->addSql('DROP TABLE gw2_fish_hole');
        $this->addSql('DROP TABLE gw2_fish_map');
        $this->addSql('DROP INDEX IDX_6A2554BEF6AAC854 ON gw2_api_item');
        $this->addSql('DROP INDEX IDX_6A2554BE69216525 ON gw2_api_item');
        $this->addSql('ALTER TABLE gw2_api_item DROP fish_achievement_id, DROP fish_hole_id');
    }
}
