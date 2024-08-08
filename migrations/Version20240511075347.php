<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240511075347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lbm_ticket (id INT AUTO_INCREMENT NOT NULL, guild_id INT NOT NULL, account_name VARCHAR(255) NOT NULL, account_access LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', account_age INT NOT NULL, account_guilds LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', email VARCHAR(255) NOT NULL, email_sent TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(25) NOT NULL, INDEX IDX_E2D5059E5F2131EF (guild_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lbm_ticket ADD CONSTRAINT FK_E2D5059E5F2131EF FOREIGN KEY (guild_id) REFERENCES lbm_ticket_guild (id)');
        $this->addSql('ALTER TABLE lbm_ticket_request DROP FOREIGN KEY FK_370AFEA55F2131EF');
        $this->addSql('DROP TABLE lbm_ticket_request');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lbm_ticket_request (id INT AUTO_INCREMENT NOT NULL, guild_id INT NOT NULL, account_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, account_access LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', account_age INT NOT NULL, account_guilds LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email_sent TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_370AFEA55F2131EF (guild_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lbm_ticket_request ADD CONSTRAINT FK_370AFEA55F2131EF FOREIGN KEY (guild_id) REFERENCES lbm_ticket_guild (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lbm_ticket DROP FOREIGN KEY FK_E2D5059E5F2131EF');
        $this->addSql('DROP TABLE lbm_ticket');
    }
}
