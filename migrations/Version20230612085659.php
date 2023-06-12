<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612085659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genshin_map_user_marker (id INT AUTO_INCREMENT NOT NULL, map_id INT NOT NULL, marker_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_497A04953C55F64 (map_id), INDEX IDX_497A049474460EB (marker_id), INDEX IDX_497A049A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genshin_map_user_marker ADD CONSTRAINT FK_497A04953C55F64 FOREIGN KEY (map_id) REFERENCES genshin_map (id)');
        $this->addSql('ALTER TABLE genshin_map_user_marker ADD CONSTRAINT FK_497A049474460EB FOREIGN KEY (marker_id) REFERENCES genshin_map_marker (id)');
        $this->addSql('ALTER TABLE genshin_map_user_marker ADD CONSTRAINT FK_497A049A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genshin_map_user_marker DROP FOREIGN KEY FK_497A04953C55F64');
        $this->addSql('ALTER TABLE genshin_map_user_marker DROP FOREIGN KEY FK_497A049474460EB');
        $this->addSql('ALTER TABLE genshin_map_user_marker DROP FOREIGN KEY FK_497A049A76ED395');
        $this->addSql('DROP TABLE genshin_map_user_marker');
    }
}
