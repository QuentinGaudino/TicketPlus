<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705134158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD incident_category_id INT DEFAULT NULL, ADD demand_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3AE6ED38F FOREIGN KEY (incident_category_id) REFERENCES incident_category (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA379DFB95E FOREIGN KEY (demand_category_id) REFERENCES demand_category (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3AE6ED38F ON ticket (incident_category_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA379DFB95E ON ticket (demand_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3AE6ED38F');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA379DFB95E');
        $this->addSql('DROP INDEX IDX_97A0ADA3AE6ED38F ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA379DFB95E ON ticket');
        $this->addSql('ALTER TABLE ticket DROP incident_category_id, DROP demand_category_id');
    }
}
