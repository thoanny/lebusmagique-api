<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527081156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genshin_map (id INT AUTO_INCREMENT NOT NULL, icon_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(55) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_DDFAC847989D9B62 (slug), INDEX IDX_DDFAC84754B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genshin_map_group (id INT AUTO_INCREMENT NOT NULL, section_id INT NOT NULL, icon_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, text LONGTEXT DEFAULT NULL, format VARCHAR(25) DEFAULT NULL, guide VARCHAR(255) DEFAULT NULL, checkbox TINYINT(1) NOT NULL, active TINYINT(1) NOT NULL, position INT DEFAULT NULL, UNIQUE INDEX UNIQ_404A6137989D9B62 (slug), INDEX IDX_404A6137D823E37A (section_id), INDEX IDX_404A613754B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genshin_map_icon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genshin_map_marker (id INT AUTO_INCREMENT NOT NULL, marker_group_id INT NOT NULL, icon_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT DEFAULT NULL, format VARCHAR(25) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, guide VARCHAR(255) DEFAULT NULL, x VARCHAR(25) NOT NULL, y VARCHAR(25) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D15139EB989D9B62 (slug), INDEX IDX_D15139EB1EFBBCC8 (marker_group_id), INDEX IDX_D15139EB54B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genshin_map_section (id INT AUTO_INCREMENT NOT NULL, map_id INT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, position INT DEFAULT NULL, INDEX IDX_40FD001D53C55F64 (map_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genshin_map ADD CONSTRAINT FK_DDFAC84754B9D732 FOREIGN KEY (icon_id) REFERENCES genshin_map_icon (id)');
        $this->addSql('ALTER TABLE genshin_map_group ADD CONSTRAINT FK_404A6137D823E37A FOREIGN KEY (section_id) REFERENCES genshin_map_section (id)');
        $this->addSql('ALTER TABLE genshin_map_group ADD CONSTRAINT FK_404A613754B9D732 FOREIGN KEY (icon_id) REFERENCES genshin_map_icon (id)');
        $this->addSql('ALTER TABLE genshin_map_marker ADD CONSTRAINT FK_D15139EB1EFBBCC8 FOREIGN KEY (marker_group_id) REFERENCES genshin_map_group (id)');
        $this->addSql('ALTER TABLE genshin_map_marker ADD CONSTRAINT FK_D15139EB54B9D732 FOREIGN KEY (icon_id) REFERENCES genshin_map_icon (id)');
        $this->addSql('ALTER TABLE genshin_map_section ADD CONSTRAINT FK_40FD001D53C55F64 FOREIGN KEY (map_id) REFERENCES genshin_map (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genshin_map DROP FOREIGN KEY FK_DDFAC84754B9D732');
        $this->addSql('ALTER TABLE genshin_map_group DROP FOREIGN KEY FK_404A6137D823E37A');
        $this->addSql('ALTER TABLE genshin_map_group DROP FOREIGN KEY FK_404A613754B9D732');
        $this->addSql('ALTER TABLE genshin_map_marker DROP FOREIGN KEY FK_D15139EB1EFBBCC8');
        $this->addSql('ALTER TABLE genshin_map_marker DROP FOREIGN KEY FK_D15139EB54B9D732');
        $this->addSql('ALTER TABLE genshin_map_section DROP FOREIGN KEY FK_40FD001D53C55F64');
        $this->addSql('DROP TABLE genshin_map');
        $this->addSql('DROP TABLE genshin_map_group');
        $this->addSql('DROP TABLE genshin_map_icon');
        $this->addSql('DROP TABLE genshin_map_marker');
        $this->addSql('DROP TABLE genshin_map_section');
    }
}
