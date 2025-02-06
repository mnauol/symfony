<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250125190137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, name VARCHAR(20) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE users');
    }
}
