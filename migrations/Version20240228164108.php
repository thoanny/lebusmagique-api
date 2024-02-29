<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228164108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective_expansion DROP FOREIGN KEY FK_4AF12A575C15249D');
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective_expansion DROP FOREIGN KEY FK_4AF12A57B510CD0B');
        $this->addSql('DROP TABLE gw2_api_wizard_vault_objective_expansion');
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective DROP period, DROP type, DROP astral_acclaim, DROP active');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gw2_api_wizard_vault_objective_expansion (wizard_vault_objective_id INT NOT NULL, expansion_id INT NOT NULL, INDEX IDX_4AF12A575C15249D (expansion_id), INDEX IDX_4AF12A57B510CD0B (wizard_vault_objective_id), PRIMARY KEY(wizard_vault_objective_id, expansion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective_expansion ADD CONSTRAINT FK_4AF12A575C15249D FOREIGN KEY (expansion_id) REFERENCES gw2_expansion (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective_expansion ADD CONSTRAINT FK_4AF12A57B510CD0B FOREIGN KEY (wizard_vault_objective_id) REFERENCES gw2_api_wizard_vault_objective (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gw2_api_wizard_vault_objective ADD period VARCHAR(10) NOT NULL, ADD type VARCHAR(3) NOT NULL, ADD astral_acclaim INT NOT NULL, ADD active TINYINT(1) DEFAULT NULL');
    }
}
