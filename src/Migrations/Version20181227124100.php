<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181227124100 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE is_published is_published TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE event CHANGE event_date event_date DATE NOT NULL');
        $this->addSql('ALTER TABLE page CHANGE content content LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE is_published is_published TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE event CHANGE event_date event_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE page CHANGE content content LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
