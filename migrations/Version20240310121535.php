<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310121535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enshrouded_item (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, level INT DEFAULT NULL, quality VARCHAR(25) NOT NULL, description LONGTEXT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, equippable VARCHAR(25) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6E8C389812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_item_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_npc (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_recipe (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, source_id INT DEFAULT NULL, output_item_id INT NOT NULL, output_quantity INT NOT NULL, output_duration INT DEFAULT NULL, INDEX IDX_D45793B412469DE2 (category_id), INDEX IDX_D45793B4953C1C61 (source_id), INDEX IDX_D45793B4CB6DD5B8 (output_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_recipe_category (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, INDEX IDX_F3D6F722A977936C (tree_root), INDEX IDX_F3D6F722727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_recipe_ingredient (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, item_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_594EE2BA59D8A214 (recipe_id), INDEX IDX_594EE2BA126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_recipe_requirement (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, source_id INT NOT NULL, INDEX IDX_A0BC9F6459D8A214 (recipe_id), INDEX IDX_A0BC9F64953C1C61 (source_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_recipe_source (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_recipe_source_item (id INT NOT NULL, item_id INT NOT NULL, UNIQUE INDEX UNIQ_65126A29126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enshrouded_recipe_source_npc (id INT NOT NULL, npc_id INT NOT NULL, UNIQUE INDEX UNIQ_2599E9A7CA7D6B89 (npc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enshrouded_item ADD CONSTRAINT FK_6E8C389812469DE2 FOREIGN KEY (category_id) REFERENCES enshrouded_item_category (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe ADD CONSTRAINT FK_D45793B412469DE2 FOREIGN KEY (category_id) REFERENCES enshrouded_recipe_category (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe ADD CONSTRAINT FK_D45793B4953C1C61 FOREIGN KEY (source_id) REFERENCES enshrouded_recipe_source (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe ADD CONSTRAINT FK_D45793B4CB6DD5B8 FOREIGN KEY (output_item_id) REFERENCES enshrouded_item (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe_category ADD CONSTRAINT FK_F3D6F722A977936C FOREIGN KEY (tree_root) REFERENCES enshrouded_recipe_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enshrouded_recipe_category ADD CONSTRAINT FK_F3D6F722727ACA70 FOREIGN KEY (parent_id) REFERENCES enshrouded_recipe_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enshrouded_recipe_ingredient ADD CONSTRAINT FK_594EE2BA59D8A214 FOREIGN KEY (recipe_id) REFERENCES enshrouded_recipe (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe_ingredient ADD CONSTRAINT FK_594EE2BA126F525E FOREIGN KEY (item_id) REFERENCES enshrouded_item (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe_requirement ADD CONSTRAINT FK_A0BC9F6459D8A214 FOREIGN KEY (recipe_id) REFERENCES enshrouded_recipe (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe_requirement ADD CONSTRAINT FK_A0BC9F64953C1C61 FOREIGN KEY (source_id) REFERENCES enshrouded_recipe_source (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe_source_item ADD CONSTRAINT FK_65126A29126F525E FOREIGN KEY (item_id) REFERENCES enshrouded_item (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe_source_item ADD CONSTRAINT FK_65126A29BF396750 FOREIGN KEY (id) REFERENCES enshrouded_recipe_source (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enshrouded_recipe_source_npc ADD CONSTRAINT FK_2599E9A7CA7D6B89 FOREIGN KEY (npc_id) REFERENCES enshrouded_npc (id)');
        $this->addSql('ALTER TABLE enshrouded_recipe_source_npc ADD CONSTRAINT FK_2599E9A7BF396750 FOREIGN KEY (id) REFERENCES enshrouded_recipe_source (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enshrouded_item DROP FOREIGN KEY FK_6E8C389812469DE2');
        $this->addSql('ALTER TABLE enshrouded_recipe DROP FOREIGN KEY FK_D45793B412469DE2');
        $this->addSql('ALTER TABLE enshrouded_recipe DROP FOREIGN KEY FK_D45793B4953C1C61');
        $this->addSql('ALTER TABLE enshrouded_recipe DROP FOREIGN KEY FK_D45793B4CB6DD5B8');
        $this->addSql('ALTER TABLE enshrouded_recipe_category DROP FOREIGN KEY FK_F3D6F722A977936C');
        $this->addSql('ALTER TABLE enshrouded_recipe_category DROP FOREIGN KEY FK_F3D6F722727ACA70');
        $this->addSql('ALTER TABLE enshrouded_recipe_ingredient DROP FOREIGN KEY FK_594EE2BA59D8A214');
        $this->addSql('ALTER TABLE enshrouded_recipe_ingredient DROP FOREIGN KEY FK_594EE2BA126F525E');
        $this->addSql('ALTER TABLE enshrouded_recipe_requirement DROP FOREIGN KEY FK_A0BC9F6459D8A214');
        $this->addSql('ALTER TABLE enshrouded_recipe_requirement DROP FOREIGN KEY FK_A0BC9F64953C1C61');
        $this->addSql('ALTER TABLE enshrouded_recipe_source_item DROP FOREIGN KEY FK_65126A29126F525E');
        $this->addSql('ALTER TABLE enshrouded_recipe_source_item DROP FOREIGN KEY FK_65126A29BF396750');
        $this->addSql('ALTER TABLE enshrouded_recipe_source_npc DROP FOREIGN KEY FK_2599E9A7CA7D6B89');
        $this->addSql('ALTER TABLE enshrouded_recipe_source_npc DROP FOREIGN KEY FK_2599E9A7BF396750');
        $this->addSql('DROP TABLE enshrouded_item');
        $this->addSql('DROP TABLE enshrouded_item_category');
        $this->addSql('DROP TABLE enshrouded_npc');
        $this->addSql('DROP TABLE enshrouded_recipe');
        $this->addSql('DROP TABLE enshrouded_recipe_category');
        $this->addSql('DROP TABLE enshrouded_recipe_ingredient');
        $this->addSql('DROP TABLE enshrouded_recipe_requirement');
        $this->addSql('DROP TABLE enshrouded_recipe_source');
        $this->addSql('DROP TABLE enshrouded_recipe_source_item');
        $this->addSql('DROP TABLE enshrouded_recipe_source_npc');
    }
}
