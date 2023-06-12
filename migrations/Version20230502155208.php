<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502155208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_api_item ADD is_fish TINYINT(1) DEFAULT NULL, ADD fish_power VARCHAR(55) DEFAULT NULL, ADD fish_time VARCHAR(2) DEFAULT NULL, ADD fish_specialization VARCHAR(25) DEFAULT NULL, ADD is_fish_strange_diet_achievement TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_api_item DROP is_fish, DROP fish_power, DROP fish_time, DROP fish_specialization, DROP is_fish_strange_diet_achievement');
    }
}
