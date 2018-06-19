<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180619123644 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE restaurant ADD COLUMN categories CLOB DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__restaurant AS SELECT id, title, description, permalink, created_at, vegan, address, ratings FROM restaurant');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('CREATE TABLE restaurant (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, permalink VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, vegan VARCHAR(30) NOT NULL, address VARCHAR(255) NOT NULL, ratings DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO restaurant (id, title, description, permalink, created_at, vegan, address, ratings) SELECT id, title, description, permalink, created_at, vegan, address, ratings FROM __temp__restaurant');
        $this->addSql('DROP TABLE __temp__restaurant');
    }
}
