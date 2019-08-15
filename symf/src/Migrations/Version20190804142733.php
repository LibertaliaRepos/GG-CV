<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804142733 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contactType (id INT AUTO_INCREMENT NOT NULL, short_name VARCHAR(255) NOT NULL, long_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE xppro ADD contract_type_id INT NOT NULL, DROP type');
        $this->addSql('ALTER TABLE xppro ADD CONSTRAINT FK_F04AF362CD1DF15B FOREIGN KEY (contract_type_id) REFERENCES contactType (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F04AF362CD1DF15B ON xppro (contract_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE xppro DROP FOREIGN KEY FK_F04AF362CD1DF15B');
        $this->addSql('DROP TABLE contactType');
        $this->addSql('DROP INDEX UNIQ_F04AF362CD1DF15B ON xppro');
        $this->addSql('ALTER TABLE xppro ADD type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP contract_type_id');
    }
}
