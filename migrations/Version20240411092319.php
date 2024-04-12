<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411092319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enshrouded_map_category (id INT AUTO_INCREMENT NOT NULL, icon_id INT NOT NULL, icon_checked_id INT DEFAULT NULL, uid VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, visible TINYINT(1) DEFAULT NULL, checked TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_3332B131539B0606 (uid), INDEX IDX_3332B13154B9D732 (icon_id), INDEX IDX_3332B131F11E7DBC (icon_checked_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_map_icon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_map_marker (id INT AUTO_INCREMENT NOT NULL, icon_id INT DEFAULT NULL, icon_checked_id INT DEFAULT NULL, category_id INT NOT NULL, uid VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, pos_x DOUBLE PRECISION NOT NULL, pos_y DOUBLE PRECISION NOT NULL, image VARCHAR(255) DEFAULT NULL, video VARCHAR(25) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E376844E54B9D732 (icon_id), INDEX IDX_E376844EF11E7DBC (icon_checked_id), INDEX IDX_E376844E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enshrouded_map_category ADD CONSTRAINT FK_3332B13154B9D732 FOREIGN KEY (icon_id) REFERENCES enshrouded_map_icon (id)');
        $this->addSql('ALTER TABLE enshrouded_map_category ADD CONSTRAINT FK_3332B131F11E7DBC FOREIGN KEY (icon_checked_id) REFERENCES enshrouded_map_icon (id)');
        $this->addSql('ALTER TABLE enshrouded_map_marker ADD CONSTRAINT FK_E376844E54B9D732 FOREIGN KEY (icon_id) REFERENCES enshrouded_map_icon (id)');
        $this->addSql('ALTER TABLE enshrouded_map_marker ADD CONSTRAINT FK_E376844EF11E7DBC FOREIGN KEY (icon_checked_id) REFERENCES enshrouded_map_icon (id)');
        $this->addSql('ALTER TABLE enshrouded_map_marker ADD CONSTRAINT FK_E376844E12469DE2 FOREIGN KEY (category_id) REFERENCES enshrouded_map_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enshrouded_map_category DROP FOREIGN KEY FK_3332B13154B9D732');
        $this->addSql('ALTER TABLE enshrouded_map_category DROP FOREIGN KEY FK_3332B131F11E7DBC');
        $this->addSql('ALTER TABLE enshrouded_map_marker DROP FOREIGN KEY FK_E376844E54B9D732');
        $this->addSql('ALTER TABLE enshrouded_map_marker DROP FOREIGN KEY FK_E376844EF11E7DBC');
        $this->addSql('ALTER TABLE enshrouded_map_marker DROP FOREIGN KEY FK_E376844E12469DE2');
        $this->addSql('DROP TABLE enshrouded_map_category');
        $this->addSql('DROP TABLE enshrouded_map_icon');
        $this->addSql('DROP TABLE enshrouded_map_marker');
    }
}
