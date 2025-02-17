<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250126162710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        
        $this->addSql('CREATE TABLE task (id SERIAL NOT NULL, task VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, completed BOOLEAN NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE task');
    }
}
