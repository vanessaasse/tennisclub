<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190119170914 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E663DA5256D');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA73DA5256D');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP INDEX UNIQ_23A0E663DA5256D ON article');
        $this->addSql('ALTER TABLE article ADD image VARCHAR(255) NOT NULL, ADD updated_at DATETIME NOT NULL, DROP image_id');
        $this->addSql('DROP INDEX UNIQ_3BAE0AA73DA5256D ON event');
        $this->addSql('ALTER TABLE event ADD image VARCHAR(255) NOT NULL, ADD updated_at DATETIME NOT NULL, DROP image_id');
        $this->addSql('ALTER TABLE page ADD image VARCHAR(255) NOT NULL, ADD updated_at DATETIME NOT NULL, DROP image_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article ADD image_id INT DEFAULT NULL, DROP image, DROP updated_at');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E663DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E663DA5256D ON article (image_id)');
        $this->addSql('ALTER TABLE event ADD image_id INT DEFAULT NULL, DROP image, DROP updated_at');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA73DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA73DA5256D ON event (image_id)');
        $this->addSql('ALTER TABLE page ADD image_id INT DEFAULT NULL, DROP image, DROP updated_at');
    }
}
