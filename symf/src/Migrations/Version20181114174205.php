<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181114174205 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_E0159763F5299398 ON skill_image');
        $this->addSql('ALTER TABLE skill_image CHANGE `order` sorting INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E0159763B1AF6E5E ON skill_image (sorting)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_E0159763B1AF6E5E ON skill_image');
        $this->addSql('ALTER TABLE skill_image CHANGE sorting `order` INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E0159763F5299398 ON skill_image (`order`)');
    }
}
