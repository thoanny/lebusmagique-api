<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240819102104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE decoration_decoration_category (decoration_id INT NOT NULL, decoration_category_id INT NOT NULL, INDEX IDX_E08CC5D63446DFC4 (decoration_id), INDEX IDX_E08CC5D6EE7B071B (decoration_category_id), PRIMARY KEY(decoration_id, decoration_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE decoration_decoration_category ADD CONSTRAINT FK_E08CC5D63446DFC4 FOREIGN KEY (decoration_id) REFERENCES gw2_decoration (id)');
        $this->addSql('ALTER TABLE decoration_decoration_category ADD CONSTRAINT FK_E08CC5D6EE7B071B FOREIGN KEY (decoration_category_id) REFERENCES gw2_decoration_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gw2_decoration DROP FOREIGN KEY FK_896525A12469DE2');
        $this->addSql('DROP INDEX IDX_896525A12469DE2 ON gw2_decoration');
        $this->addSql('ALTER TABLE gw2_decoration DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE decoration_decoration_category DROP FOREIGN KEY FK_E08CC5D63446DFC4');
        $this->addSql('ALTER TABLE decoration_decoration_category DROP FOREIGN KEY FK_E08CC5D6EE7B071B');
        $this->addSql('DROP TABLE decoration_decoration_category');
        $this->addSql('ALTER TABLE gw2_decoration ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE gw2_decoration ADD CONSTRAINT FK_896525A12469DE2 FOREIGN KEY (category_id) REFERENCES gw2_decoration_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_896525A12469DE2 ON gw2_decoration (category_id)');
    }
}
