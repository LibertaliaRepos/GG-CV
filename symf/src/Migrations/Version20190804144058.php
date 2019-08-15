<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804144058 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contractType (id INT AUTO_INCREMENT NOT NULL, short_name VARCHAR(255) NOT NULL, long_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE xppro ADD contract_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE xppro ADD CONSTRAINT FK_F04AF362CD1DF15B FOREIGN KEY (contract_type_id) REFERENCES contractType (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F04AF362CD1DF15B ON xppro (contract_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE xppro DROP FOREIGN KEY FK_F04AF362CD1DF15B');
        $this->addSql('DROP TABLE contractType');
        $this->addSql('DROP INDEX UNIQ_F04AF362CD1DF15B ON xppro');
        $this->addSql('ALTER TABLE xppro DROP contract_type_id');
    }
}
