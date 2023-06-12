<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517073556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_api_recipe (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, uid INT NOT NULL, quantity INT NOT NULL, data JSON NOT NULL, INDEX IDX_538D394A126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_api_recipe_ingredient (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, recipe_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_E45673AC126F525E (item_id), INDEX IDX_E45673AC59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gw2_api_recipe ADD CONSTRAINT FK_538D394A126F525E FOREIGN KEY (item_id) REFERENCES gw2_api_item (id)');
        $this->addSql('ALTER TABLE gw2_api_recipe_ingredient ADD CONSTRAINT FK_E45673AC126F525E FOREIGN KEY (item_id) REFERENCES gw2_api_item (id)');
        $this->addSql('ALTER TABLE gw2_api_recipe_ingredient ADD CONSTRAINT FK_E45673AC59D8A214 FOREIGN KEY (recipe_id) REFERENCES gw2_api_recipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_api_recipe DROP FOREIGN KEY FK_538D394A126F525E');
        $this->addSql('ALTER TABLE gw2_api_recipe_ingredient DROP FOREIGN KEY FK_E45673AC126F525E');
        $this->addSql('ALTER TABLE gw2_api_recipe_ingredient DROP FOREIGN KEY FK_E45673AC59D8A214');
        $this->addSql('DROP TABLE gw2_api_recipe');
        $this->addSql('DROP TABLE gw2_api_recipe_ingredient');
    }
}
