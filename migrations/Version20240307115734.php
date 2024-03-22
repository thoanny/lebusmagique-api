<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307115734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lbm_ticket_blacklist (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, account_name VARCHAR(255) NOT NULL, reason LONGTEXT NOT NULL, comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_39BCC0CBD2B0F9AC (account_name), INDEX IDX_39BCC0CBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lbm_ticket_guild (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(25) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, sort_order INT NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_AB182411539B0606 (uid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lbm_ticket_request (id INT AUTO_INCREMENT NOT NULL, guild_id INT NOT NULL, account_name VARCHAR(255) NOT NULL, account_access LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', account_age INT NOT NULL, account_guilds LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', email VARCHAR(255) NOT NULL, email_sent TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(25) NOT NULL, INDEX IDX_370AFEA55F2131EF (guild_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lbm_ticket_validate (id INT AUTO_INCREMENT NOT NULL, guild_id INT NOT NULL, title VARCHAR(255) NOT NULL, leader VARCHAR(255) NOT NULL, players LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', active TINYINT(1) NOT NULL, INDEX IDX_841276975F2131EF (guild_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lbm_ticket_blacklist ADD CONSTRAINT FK_39BCC0CBA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE lbm_ticket_request ADD CONSTRAINT FK_370AFEA55F2131EF FOREIGN KEY (guild_id) REFERENCES lbm_ticket_guild (id)');
        $this->addSql('ALTER TABLE lbm_ticket_validate ADD CONSTRAINT FK_841276975F2131EF FOREIGN KEY (guild_id) REFERENCES lbm_ticket_guild (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lbm_ticket_blacklist DROP FOREIGN KEY FK_39BCC0CBA76ED395');
        $this->addSql('ALTER TABLE lbm_ticket_request DROP FOREIGN KEY FK_370AFEA55F2131EF');
        $this->addSql('ALTER TABLE lbm_ticket_validate DROP FOREIGN KEY FK_841276975F2131EF');
        $this->addSql('DROP TABLE lbm_ticket_blacklist');
        $this->addSql('DROP TABLE lbm_ticket_guild');
        $this->addSql('DROP TABLE lbm_ticket_request');
        $this->addSql('DROP TABLE lbm_ticket_validate');
    }
}
