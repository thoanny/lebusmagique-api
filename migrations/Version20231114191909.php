<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114191909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_api_wizard_vault_objective (id INT AUTO_INCREMENT NOT NULL, uid INT DEFAULT NULL, title VARCHAR(255) NOT NULL, period VARCHAR(10) NOT NULL, type VARCHAR(3) NOT NULL, tip LONGTEXT NOT NULL, astral_acclaim INT NOT NULL, active TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_api_wizard_vault_objective_expansion (wizard_vault_objective_id INT NOT NULL, expansion_id INT NOT NULL, INDEX IDX_4AF12A57B510CD0B (wizard_vault_objective_id), INDEX IDX_4AF12A575C15249D (expansion_id), PRIMARY KEY(wizard_vault_objective_id, expansion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gw2_expansion (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(55) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective_expansion ADD CONSTRAINT FK_4AF12A57B510CD0B FOREIGN KEY (wizard_vault_objective_id) REFERENCES gw2_api_wizard_vault_objective (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective_expansion ADD CONSTRAINT FK_4AF12A575C15249D FOREIGN KEY (expansion_id) REFERENCES gw2_expansion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective_expansion DROP FOREIGN KEY FK_4AF12A57B510CD0B');
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective_expansion DROP FOREIGN KEY FK_4AF12A575C15249D');
        $this->addSql('DROP TABLE gw2_api_wizard_vault_objective');
        $this->addSql('DROP TABLE gw2_api_wizard_vault_objective_expansion');
        $this->addSql('DROP TABLE gw2_expansion');
    }
}
