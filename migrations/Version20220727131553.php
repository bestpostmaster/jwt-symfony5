<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727131553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hosted_file DROP real_dir');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(255) DEFAULT NULL, ADD phone_number VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD zip_code VARCHAR(255) DEFAULT NULL, ADD preferred_language VARCHAR(255) DEFAULT NULL, ADD type_of_account VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD avatar_picture VARCHAR(255) DEFAULT NULL, ADD date_of_birth DATETIME DEFAULT NULL, ADD is_banned TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hosted_file ADD real_dir VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP email, DROP phone_number, DROP city, DROP country, DROP zip_code, DROP preferred_language, DROP type_of_account, DROP description, DROP avatar_picture, DROP date_of_birth, DROP is_banned');
    }
}
