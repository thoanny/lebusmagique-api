<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230827133724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE palia_character (id INT AUTO_INCREMENT NOT NULL, character_group_id INT DEFAULT NULL, skill_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, romance TINYINT(1) DEFAULT NULL, shepp TINYINT(1) DEFAULT NULL, INDEX IDX_4DD9B28FA65530D6 (character_group_id), UNIQUE INDEX UNIQ_4DD9B28F5585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_character_location (character_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_D0FC8DCB1136BE75 (character_id), INDEX IDX_D0FC8DCB64D218E (location_id), PRIMARY KEY(character_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_character_gift (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, palia_character_id INT NOT NULL, love TINYINT(1) DEFAULT NULL, INDEX IDX_BA1B77B3126F525E (item_id), INDEX IDX_BA1B77B3A5D43F8A (palia_character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_character_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_character_wish (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, palia_character_id INT NOT NULL, INDEX IDX_C9B69A77126F525E (item_id), INDEX IDX_C9B69A77A5D43F8A (palia_character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_currency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_item (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, rarity VARCHAR(10) NOT NULL, description LONGTEXT DEFAULT NULL, focus INT DEFAULT NULL, price_base INT NOT NULL, price_quality INT NOT NULL, comment LONGTEXT DEFAULT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8005BA2C12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_item_location (item_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_1F254C0C126F525E (item_id), INDEX IDX_1F254C0C64D218E (location_id), PRIMARY KEY(item_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_item_buy (id INT AUTO_INCREMENT NOT NULL, currency_id INT NOT NULL, item_id INT NOT NULL, source VARCHAR(55) NOT NULL, price INT NOT NULL, quantity INT NOT NULL, INDEX IDX_300A87A838248176 (currency_id), INDEX IDX_300A87A8126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_item_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_recipe (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, workshop_id INT NOT NULL, skill_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_5748F48D126F525E (item_id), INDEX IDX_5748F48D1FDCE57C (workshop_id), INDEX IDX_5748F48D5585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_recipe_ingredient (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, recipe_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_979F87B3126F525E (item_id), INDEX IDX_979F87B359D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE palia_skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE palia_character ADD CONSTRAINT FK_4DD9B28FA65530D6 FOREIGN KEY (character_group_id) REFERENCES palia_character_group (id)');
        $this->addSql('ALTER TABLE palia_character ADD CONSTRAINT FK_4DD9B28F5585C142 FOREIGN KEY (skill_id) REFERENCES palia_skill (id)');
        $this->addSql('ALTER TABLE palia_character_location ADD CONSTRAINT FK_D0FC8DCB1136BE75 FOREIGN KEY (character_id) REFERENCES palia_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE palia_character_location ADD CONSTRAINT FK_D0FC8DCB64D218E FOREIGN KEY (location_id) REFERENCES palia_location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE palia_character_gift ADD CONSTRAINT FK_BA1B77B3126F525E FOREIGN KEY (item_id) REFERENCES palia_item (id)');
        $this->addSql('ALTER TABLE palia_character_gift ADD CONSTRAINT FK_BA1B77B3A5D43F8A FOREIGN KEY (palia_character_id) REFERENCES palia_character (id)');
        $this->addSql('ALTER TABLE palia_character_wish ADD CONSTRAINT FK_C9B69A77126F525E FOREIGN KEY (item_id) REFERENCES palia_item (id)');
        $this->addSql('ALTER TABLE palia_character_wish ADD CONSTRAINT FK_C9B69A77A5D43F8A FOREIGN KEY (palia_character_id) REFERENCES palia_character (id)');
        $this->addSql('ALTER TABLE palia_item ADD CONSTRAINT FK_8005BA2C12469DE2 FOREIGN KEY (category_id) REFERENCES palia_item_category (id)');
        $this->addSql('ALTER TABLE palia_item_location ADD CONSTRAINT FK_1F254C0C126F525E FOREIGN KEY (item_id) REFERENCES palia_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE palia_item_location ADD CONSTRAINT FK_1F254C0C64D218E FOREIGN KEY (location_id) REFERENCES palia_location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE palia_item_buy ADD CONSTRAINT FK_300A87A838248176 FOREIGN KEY (currency_id) REFERENCES palia_currency (id)');
        $this->addSql('ALTER TABLE palia_item_buy ADD CONSTRAINT FK_300A87A8126F525E FOREIGN KEY (item_id) REFERENCES palia_item (id)');
        $this->addSql('ALTER TABLE palia_recipe ADD CONSTRAINT FK_5748F48D126F525E FOREIGN KEY (item_id) REFERENCES palia_item (id)');
        $this->addSql('ALTER TABLE palia_recipe ADD CONSTRAINT FK_5748F48D1FDCE57C FOREIGN KEY (workshop_id) REFERENCES palia_item (id)');
        $this->addSql('ALTER TABLE palia_recipe ADD CONSTRAINT FK_5748F48D5585C142 FOREIGN KEY (skill_id) REFERENCES palia_skill (id)');
        $this->addSql('ALTER TABLE palia_recipe_ingredient ADD CONSTRAINT FK_979F87B3126F525E FOREIGN KEY (item_id) REFERENCES palia_item (id)');
        $this->addSql('ALTER TABLE palia_recipe_ingredient ADD CONSTRAINT FK_979F87B359D8A214 FOREIGN KEY (recipe_id) REFERENCES palia_recipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE palia_character DROP FOREIGN KEY FK_4DD9B28FA65530D6');
        $this->addSql('ALTER TABLE palia_character DROP FOREIGN KEY FK_4DD9B28F5585C142');
        $this->addSql('ALTER TABLE palia_character_location DROP FOREIGN KEY FK_D0FC8DCB1136BE75');
        $this->addSql('ALTER TABLE palia_character_location DROP FOREIGN KEY FK_D0FC8DCB64D218E');
        $this->addSql('ALTER TABLE palia_character_gift DROP FOREIGN KEY FK_BA1B77B3126F525E');
        $this->addSql('ALTER TABLE palia_character_gift DROP FOREIGN KEY FK_BA1B77B3A5D43F8A');
        $this->addSql('ALTER TABLE palia_character_wish DROP FOREIGN KEY FK_C9B69A77126F525E');
        $this->addSql('ALTER TABLE palia_character_wish DROP FOREIGN KEY FK_C9B69A77A5D43F8A');
        $this->addSql('ALTER TABLE palia_item DROP FOREIGN KEY FK_8005BA2C12469DE2');
        $this->addSql('ALTER TABLE palia_item_location DROP FOREIGN KEY FK_1F254C0C126F525E');
        $this->addSql('ALTER TABLE palia_item_location DROP FOREIGN KEY FK_1F254C0C64D218E');
        $this->addSql('ALTER TABLE palia_item_buy DROP FOREIGN KEY FK_300A87A838248176');
        $this->addSql('ALTER TABLE palia_item_buy DROP FOREIGN KEY FK_300A87A8126F525E');
        $this->addSql('ALTER TABLE palia_recipe DROP FOREIGN KEY FK_5748F48D126F525E');
        $this->addSql('ALTER TABLE palia_recipe DROP FOREIGN KEY FK_5748F48D1FDCE57C');
        $this->addSql('ALTER TABLE palia_recipe DROP FOREIGN KEY FK_5748F48D5585C142');
        $this->addSql('ALTER TABLE palia_recipe_ingredient DROP FOREIGN KEY FK_979F87B3126F525E');
        $this->addSql('ALTER TABLE palia_recipe_ingredient DROP FOREIGN KEY FK_979F87B359D8A214');
        $this->addSql('DROP TABLE palia_character');
        $this->addSql('DROP TABLE palia_character_location');
        $this->addSql('DROP TABLE palia_character_gift');
        $this->addSql('DROP TABLE palia_character_group');
        $this->addSql('DROP TABLE palia_character_wish');
        $this->addSql('DROP TABLE palia_currency');
        $this->addSql('DROP TABLE palia_item');
        $this->addSql('DROP TABLE palia_item_location');
        $this->addSql('DROP TABLE palia_item_buy');
        $this->addSql('DROP TABLE palia_item_category');
        $this->addSql('DROP TABLE palia_location');
        $this->addSql('DROP TABLE palia_recipe');
        $this->addSql('DROP TABLE palia_recipe_ingredient');
        $this->addSql('DROP TABLE palia_skill');
    }
}
