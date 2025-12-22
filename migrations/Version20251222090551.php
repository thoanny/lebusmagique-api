<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251222090551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_fish DROP FOREIGN KEY FK_7B02FDFDAB926098');
        $this->addSql('ALTER TABLE gw2_fish DROP FOREIGN KEY FK_7B02FDFDB3EC99FE');
        $this->addSql('ALTER TABLE gw2_fish DROP FOREIGN KEY FK_7B02FDFD126F525E');
        $this->addSql('ALTER TABLE gw2_fish_bait DROP FOREIGN KEY FK_4CEB7A96126F525E');
        $this->addSql('ALTER TABLE gw2_fish_daily DROP FOREIGN KEY FK_EFA096E78311A1E2');
        $this->addSql('ALTER TABLE gw2_fish_fish_hole DROP FOREIGN KEY FK_AFE4AB5315ADE12C');
        $this->addSql('ALTER TABLE gw2_fish_fish_hole DROP FOREIGN KEY FK_AFE4AB538311A1E2');
        $this->addSql('ALTER TABLE gw2_fish_fish_time DROP FOREIGN KEY FK_A8BD0E875EEADD3B');
        $this->addSql('ALTER TABLE gw2_fish_fish_time DROP FOREIGN KEY FK_A8BD0E878311A1E2');
        $this->addSql('ALTER TABLE gw2_fish_map DROP FOREIGN KEY FK_E237578EF6AAC854');
        $this->addSql('DROP TABLE gw2_fish');
        $this->addSql('DROP TABLE gw2_fish_achievement');
        $this->addSql('DROP TABLE gw2_fish_bait');
        $this->addSql('DROP TABLE gw2_fish_daily');
        $this->addSql('DROP TABLE gw2_fish_fish_hole');
        $this->addSql('DROP TABLE gw2_fish_fish_time');
        $this->addSql('DROP TABLE gw2_fish_hole');
        $this->addSql('DROP TABLE gw2_fish_map');
        $this->addSql('DROP TABLE gw2_fish_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_fish (id INT AUTO_INCREMENT NOT NULL, achievement_id INT DEFAULT NULL, bait_id INT DEFAULT NULL, item_id INT DEFAULT NULL, power VARCHAR(55) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, specialization VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, strange_diet TINYINT(1) DEFAULT NULL, bait_any TINYINT(1) DEFAULT NULL, INDEX IDX_7B02FDFDB3EC99FE (achievement_id), INDEX IDX_7B02FDFDAB926098 (bait_id), UNIQUE INDEX UNIQ_7B02FDFD126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gw2_fish_achievement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, achievement_id INT NOT NULL, achievement_repeat_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gw2_fish_bait (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, power VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_4CEB7A96126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gw2_fish_daily (id INT AUTO_INCREMENT NOT NULL, fish_id INT NOT NULL, day DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_EFA096E78311A1E2 (fish_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gw2_fish_fish_hole (id INT AUTO_INCREMENT NOT NULL, fish_id INT NOT NULL, hole_id INT NOT NULL, frequency VARCHAR(5) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_AFE4AB538311A1E2 (fish_id), INDEX IDX_AFE4AB5315ADE12C (hole_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gw2_fish_fish_time (id INT AUTO_INCREMENT NOT NULL, fish_id INT NOT NULL, time_id INT NOT NULL, frequency VARCHAR(5) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_A8BD0E875EEADD3B (time_id), INDEX IDX_A8BD0E878311A1E2 (fish_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gw2_fish_hole (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gw2_fish_map (id INT AUTO_INCREMENT NOT NULL, fish_achievement_id INT NOT NULL, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, map_id INT NOT NULL, INDEX IDX_E237578EF6AAC854 (fish_achievement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE gw2_fish_time (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE gw2_fish ADD CONSTRAINT FK_7B02FDFDAB926098 FOREIGN KEY (bait_id) REFERENCES gw2_fish_bait (id)');
        $this->addSql('ALTER TABLE gw2_fish ADD CONSTRAINT FK_7B02FDFDB3EC99FE FOREIGN KEY (achievement_id) REFERENCES gw2_fish_achievement (id)');
        $this->addSql('ALTER TABLE gw2_fish ADD CONSTRAINT FK_7B02FDFD126F525E FOREIGN KEY (item_id) REFERENCES gw2_api_item (id)');
        $this->addSql('ALTER TABLE gw2_fish_bait ADD CONSTRAINT FK_4CEB7A96126F525E FOREIGN KEY (item_id) REFERENCES gw2_api_item (id)');
        $this->addSql('ALTER TABLE gw2_fish_daily ADD CONSTRAINT FK_EFA096E78311A1E2 FOREIGN KEY (fish_id) REFERENCES gw2_fish (id)');
        $this->addSql('ALTER TABLE gw2_fish_fish_hole ADD CONSTRAINT FK_AFE4AB5315ADE12C FOREIGN KEY (hole_id) REFERENCES gw2_fish_hole (id)');
        $this->addSql('ALTER TABLE gw2_fish_fish_hole ADD CONSTRAINT FK_AFE4AB538311A1E2 FOREIGN KEY (fish_id) REFERENCES gw2_fish (id)');
        $this->addSql('ALTER TABLE gw2_fish_fish_time ADD CONSTRAINT FK_A8BD0E875EEADD3B FOREIGN KEY (time_id) REFERENCES gw2_fish_time (id)');
        $this->addSql('ALTER TABLE gw2_fish_fish_time ADD CONSTRAINT FK_A8BD0E878311A1E2 FOREIGN KEY (fish_id) REFERENCES gw2_fish (id)');
        $this->addSql('ALTER TABLE gw2_fish_map ADD CONSTRAINT FK_E237578EF6AAC854 FOREIGN KEY (fish_achievement_id) REFERENCES gw2_fish_achievement (id)');
    }
}
