<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181028140507 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DDE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_444F97DDE7A1254A ON phone (contact_id)');
        $this->addSql('ALTER TABLE contact MODIFY id_contact INT NOT NULL');
        $this->addSql('ALTER TABLE contact DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE contact CHANGE id_contact id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE contact ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE Society MODIFY id_society INT NOT NULL');
        $this->addSql('ALTER TABLE Society DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE Society ADD contact_id INT NOT NULL, CHANGE id_society id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE Society ADD CONSTRAINT FK_C2D9586EE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2D9586EE7A1254A ON Society (contact_id)');
        $this->addSql('ALTER TABLE Society ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE author MODIFY id_author INT NOT NULL');
        $this->addSql('ALTER TABLE author DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE author ADD contact_id INT NOT NULL, CHANGE id_author id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE author ADD CONSTRAINT FK_BDAFD8C8E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDAFD8C8E7A1254A ON author (contact_id)');
        $this->addSql('ALTER TABLE author ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Society MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE Society DROP FOREIGN KEY FK_C2D9586EE7A1254A');
        $this->addSql('DROP INDEX UNIQ_C2D9586EE7A1254A ON Society');
        $this->addSql('ALTER TABLE Society DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE Society DROP contact_id, CHANGE id id_society INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE Society ADD PRIMARY KEY (id_society)');
        $this->addSql('ALTER TABLE author MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE author DROP FOREIGN KEY FK_BDAFD8C8E7A1254A');
        $this->addSql('DROP INDEX UNIQ_BDAFD8C8E7A1254A ON author');
        $this->addSql('ALTER TABLE author DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE author DROP contact_id, CHANGE id id_author INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE author ADD PRIMARY KEY (id_author)');
        $this->addSql('ALTER TABLE contact MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE contact DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE contact CHANGE id id_contact INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE contact ADD PRIMARY KEY (id_contact)');
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DDE7A1254A');
        $this->addSql('DROP INDEX UNIQ_444F97DDE7A1254A ON phone');
    }
}
