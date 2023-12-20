<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220135129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(20) NOT NULL, CHANGE birth_date birth_date DATE NOT NULL, CHANGE phone phone VARCHAR(20) NOT NULL, CHANGE adress adress VARCHAR(255) NOT NULL, CHANGE postcode postcode VARCHAR(255) NOT NULL, CHANGE city city VARCHAR(255) NOT NULL, CHANGE reset_token reset_token VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` CHANGE gender gender VARCHAR(20) DEFAULT NULL, CHANGE birth_date birth_date DATE DEFAULT NULL, CHANGE phone phone VARCHAR(20) DEFAULT NULL, CHANGE adress adress VARCHAR(255) DEFAULT NULL, CHANGE postcode postcode VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE reset_token reset_token VARCHAR(100) DEFAULT NULL');
    }
}
