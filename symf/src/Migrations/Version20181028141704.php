<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181028141704 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, contact_id INT NOT NULL, number VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_444F97DDE7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, anchor VARCHAR(255) NOT NULL, explanation LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_5E3DE4776751117D (anchor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, anchor VARCHAR(255) NOT NULL, explanation LONGTEXT NOT NULL, UNIQUE INDEX project_anchor_IDX (anchor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Society (id INT AUTO_INCREMENT NOT NULL, contact_id INT NOT NULL, society_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C2D9586EE7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, contact_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BDAFD8C8E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DDE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE Society ADD CONSTRAINT FK_C2D9586EE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE author ADD CONSTRAINT FK_BDAFD8C8E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DDE7A1254A');
        $this->addSql('ALTER TABLE Society DROP FOREIGN KEY FK_C2D9586EE7A1254A');
        $this->addSql('ALTER TABLE author DROP FOREIGN KEY FK_BDAFD8C8E7A1254A');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE Society');
        $this->addSql('DROP TABLE author');
    }
}
