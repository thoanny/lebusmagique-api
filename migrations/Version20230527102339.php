<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527102339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genshin_map ADD bounds VARCHAR(255) NOT NULL, ADD center VARCHAR(25) NOT NULL, ADD zoom INT NOT NULL, ADD tiles VARCHAR(255) NOT NULL, ADD min_zoom INT NOT NULL, ADD max_zoom INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genshin_map DROP bounds, DROP center, DROP zoom, DROP tiles, DROP min_zoom, DROP max_zoom');
    }
}
