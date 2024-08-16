<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240808161456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_decoration (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, category_id INT NOT NULL, description LONGTEXT DEFAULT NULL, thumbnail VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_896525A126F525E (item_id), INDEX IDX_896525A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_decoration_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gw2_decoration ADD CONSTRAINT FK_896525A126F525E FOREIGN KEY (item_id) REFERENCES gw2_api_item (id)');
        $this->addSql('ALTER TABLE gw2_decoration ADD CONSTRAINT FK_896525A12469DE2 FOREIGN KEY (category_id) REFERENCES gw2_decoration_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_decoration DROP FOREIGN KEY FK_896525A126F525E');
        $this->addSql('ALTER TABLE gw2_decoration DROP FOREIGN KEY FK_896525A12469DE2');
        $this->addSql('DROP TABLE gw2_decoration');
        $this->addSql('DROP TABLE gw2_decoration_category');
    }
}
