<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190729121314 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE xppro_image DROP FOREIGN KEY FK_44C0A7965585C142');
        $this->addSql('DROP INDEX UNIQ_44C0A7965585C142 ON xppro_image');
        $this->addSql('ALTER TABLE xppro_image CHANGE skill_id xp_pro_id INT NOT NULL');
        $this->addSql('ALTER TABLE xppro_image ADD CONSTRAINT FK_44C0A796A6CA38B4 FOREIGN KEY (xp_pro_id) REFERENCES xppro (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44C0A796A6CA38B4 ON xppro_image (xp_pro_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE xppro_image DROP FOREIGN KEY FK_44C0A796A6CA38B4');
        $this->addSql('DROP INDEX UNIQ_44C0A796A6CA38B4 ON xppro_image');
        $this->addSql('ALTER TABLE xppro_image CHANGE xp_pro_id skill_id INT NOT NULL');
        $this->addSql('ALTER TABLE xppro_image ADD CONSTRAINT FK_44C0A7965585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44C0A7965585C142 ON xppro_image (skill_id)');
    }
}
