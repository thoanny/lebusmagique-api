<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829083333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE palia_character ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4DD9B28F989D9B62 ON palia_character (slug)');
        $this->addSql('ALTER TABLE palia_item ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8005BA2C989D9B62 ON palia_item (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4DD9B28F989D9B62 ON palia_character');
        $this->addSql('ALTER TABLE palia_character DROP slug');
        $this->addSql('DROP INDEX UNIQ_8005BA2C989D9B62 ON palia_item');
        $this->addSql('ALTER TABLE palia_item DROP slug');
    }
}
