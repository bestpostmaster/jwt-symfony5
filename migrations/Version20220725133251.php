<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220725133251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hosted_file (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, real_dir VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, client_name VARCHAR(255) NOT NULL, upload_date DATETIME NOT NULL, expiration_date DATETIME DEFAULT NULL, virtual_directory VARCHAR(255) NOT NULL, size DOUBLE PRECISION NOT NULL, scaned TINYINT(1) NOT NULL, description VARCHAR(255) DEFAULT NULL, download_counter BIGINT NOT NULL, url VARCHAR(255) NOT NULL, upload_localisation VARCHAR(255) DEFAULT NULL, copyright_issue TINYINT(1) NOT NULL, conversions_available VARCHAR(255) DEFAULT NULL, file_password VARCHAR(255) DEFAULT NULL, authorized_users VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1D3B660EF47645AE (url), INDEX IDX_1D3B660EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, total_space_used_mo INT DEFAULT NULL, authorized_size_mo INT DEFAULT NULL, registration_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hosted_file ADD CONSTRAINT FK_1D3B660EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hosted_file DROP FOREIGN KEY FK_1D3B660EA76ED395');
        $this->addSql('DROP TABLE hosted_file');
        $this->addSql('DROP TABLE user');
    }
}
