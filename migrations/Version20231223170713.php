<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231223170713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_fish (id INT AUTO_INCREMENT NOT NULL, achievement_id INT DEFAULT NULL, bait_id INT DEFAULT NULL, item_id INT DEFAULT NULL, power VARCHAR(55) DEFAULT NULL, specialization VARCHAR(25) DEFAULT NULL, strange_diet TINYINT(1) DEFAULT NULL, bait_any TINYINT(1) DEFAULT NULL, INDEX IDX_7B02FDFDB3EC99FE (achievement_id), INDEX IDX_7B02FDFDAB926098 (bait_id), UNIQUE INDEX UNIQ_7B02FDFD126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_fish_bait (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, power VARCHAR(25) DEFAULT NULL, UNIQUE INDEX UNIQ_4CEB7A96126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_fish_fish_hole (id INT AUTO_INCREMENT NOT NULL, fish_id INT NOT NULL, hole_id INT NOT NULL, frequency VARCHAR(5) DEFAULT NULL, INDEX IDX_AFE4AB538311A1E2 (fish_id), INDEX IDX_AFE4AB5315ADE12C (hole_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_fish_fish_time (id INT AUTO_INCREMENT NOT NULL, fish_id INT NOT NULL, time_id INT NOT NULL, frequency VARCHAR(5) DEFAULT NULL, INDEX IDX_A8BD0E878311A1E2 (fish_id), INDEX IDX_A8BD0E875EEADD3B (time_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_fish_time (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(25) NOT NULL, name VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gw2_fish ADD CONSTRAINT FK_7B02FDFDB3EC99FE FOREIGN KEY (achievement_id) REFERENCES gw2_fish_achievement (id)');
        $this->addSql('ALTER TABLE gw2_fish ADD CONSTRAINT FK_7B02FDFDAB926098 FOREIGN KEY (bait_id) REFERENCES gw2_fish_bait (id)');
        $this->addSql('ALTER TABLE gw2_fish ADD CONSTRAINT FK_7B02FDFD126F525E FOREIGN KEY (item_id) REFERENCES gw2_api_item (id)');
        $this->addSql('ALTER TABLE gw2_fish_bait ADD CONSTRAINT FK_4CEB7A96126F525E FOREIGN KEY (item_id) REFERENCES gw2_api_item (id)');
        $this->addSql('ALTER TABLE gw2_fish_fish_hole ADD CONSTRAINT FK_AFE4AB538311A1E2 FOREIGN KEY (fish_id) REFERENCES gw2_fish (id)');
        $this->addSql('ALTER TABLE gw2_fish_fish_hole ADD CONSTRAINT FK_AFE4AB5315ADE12C FOREIGN KEY (hole_id) REFERENCES gw2_fish_hole (id)');
        $this->addSql('ALTER TABLE gw2_fish_fish_time ADD CONSTRAINT FK_A8BD0E878311A1E2 FOREIGN KEY (fish_id) REFERENCES gw2_fish (id)');
        $this->addSql('ALTER TABLE gw2_fish_fish_time ADD CONSTRAINT FK_A8BD0E875EEADD3B FOREIGN KEY (time_id) REFERENCES gw2_fish_time (id)');
        $this->addSql('ALTER TABLE gw2_api_item DROP FOREIGN KEY FK_6A2554BE69216525');
        $this->addSql('ALTER TABLE gw2_api_item DROP FOREIGN KEY FK_6A2554BEA9D03B2A');
        $this->addSql('ALTER TABLE gw2_api_item DROP FOREIGN KEY FK_6A2554BEF6AAC854');
        $this->addSql('DROP INDEX IDX_6A2554BEA9D03B2A ON gw2_api_item');
        $this->addSql('DROP INDEX IDX_6A2554BEF6AAC854 ON gw2_api_item');
        $this->addSql('DROP INDEX IDX_6A2554BE69216525 ON gw2_api_item');
        $this->addSql('ALTER TABLE gw2_api_item DROP fish_achievement_id, DROP fish_hole_id, DROP fish_bait_item_id, DROP is_fish, DROP fish_power, DROP fish_time, DROP fish_specialization, DROP is_fish_strange_diet_achievement, DROP is_fish_bait, DROP fish_bait_power');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_fish DROP FOREIGN KEY FK_7B02FDFDB3EC99FE');
        $this->addSql('ALTER TABLE gw2_fish DROP FOREIGN KEY FK_7B02FDFDAB926098');
        $this->addSql('ALTER TABLE gw2_fish DROP FOREIGN KEY FK_7B02FDFD126F525E');
        $this->addSql('ALTER TABLE gw2_fish_bait DROP FOREIGN KEY FK_4CEB7A96126F525E');
        $this->addSql('ALTER TABLE gw2_fish_fish_hole DROP FOREIGN KEY FK_AFE4AB538311A1E2');
        $this->addSql('ALTER TABLE gw2_fish_fish_hole DROP FOREIGN KEY FK_AFE4AB5315ADE12C');
        $this->addSql('ALTER TABLE gw2_fish_fish_time DROP FOREIGN KEY FK_A8BD0E878311A1E2');
        $this->addSql('ALTER TABLE gw2_fish_fish_time DROP FOREIGN KEY FK_A8BD0E875EEADD3B');
        $this->addSql('DROP TABLE gw2_fish');
        $this->addSql('DROP TABLE gw2_fish_bait');
        $this->addSql('DROP TABLE gw2_fish_fish_hole');
        $this->addSql('DROP TABLE gw2_fish_fish_time');
        $this->addSql('DROP TABLE gw2_fish_time');
        $this->addSql('ALTER TABLE gw2_api_item ADD fish_achievement_id INT DEFAULT NULL, ADD fish_hole_id INT DEFAULT NULL, ADD fish_bait_item_id INT DEFAULT NULL, ADD is_fish TINYINT(1) DEFAULT NULL, ADD fish_power VARCHAR(55) DEFAULT NULL, ADD fish_time VARCHAR(2) DEFAULT NULL, ADD fish_specialization VARCHAR(25) DEFAULT NULL, ADD is_fish_strange_diet_achievement TINYINT(1) DEFAULT NULL, ADD is_fish_bait TINYINT(1) DEFAULT NULL, ADD fish_bait_power VARCHAR(25) DEFAULT NULL');
        $this->addSql('ALTER TABLE gw2_api_item ADD CONSTRAINT FK_6A2554BE69216525 FOREIGN KEY (fish_hole_id) REFERENCES gw2_fish_hole (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE gw2_api_item ADD CONSTRAINT FK_6A2554BEA9D03B2A FOREIGN KEY (fish_bait_item_id) REFERENCES gw2_api_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE gw2_api_item ADD CONSTRAINT FK_6A2554BEF6AAC854 FOREIGN KEY (fish_achievement_id) REFERENCES gw2_fish_achievement (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6A2554BEA9D03B2A ON gw2_api_item (fish_bait_item_id)');
        $this->addSql('CREATE INDEX IDX_6A2554BEF6AAC854 ON gw2_api_item (fish_achievement_id)');
        $this->addSql('CREATE INDEX IDX_6A2554BE69216525 ON gw2_api_item (fish_hole_id)');
    }
}
