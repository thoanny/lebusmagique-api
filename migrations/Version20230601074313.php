<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601074313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_DDFAC847989D9B62 ON genshin_map');
        $this->addSql('ALTER TABLE genshin_map DROP slug');
        $this->addSql('DROP INDEX UNIQ_404A6137989D9B62 ON genshin_map_group');
        $this->addSql('ALTER TABLE genshin_map_group DROP slug');
        $this->addSql('DROP INDEX UNIQ_D15139EB989D9B62 ON genshin_map_marker');
        $this->addSql('ALTER TABLE genshin_map_marker DROP slug');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genshin_map ADD slug VARCHAR(55) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DDFAC847989D9B62 ON genshin_map (slug)');
        $this->addSql('ALTER TABLE genshin_map_group ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_404A6137989D9B62 ON genshin_map_group (slug)');
        $this->addSql('ALTER TABLE genshin_map_marker ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D15139EB989D9B62 ON genshin_map_marker (slug)');
    }
}
