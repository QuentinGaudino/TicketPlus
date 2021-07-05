<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705133438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demand_category (id INT AUTO_INCREMENT NOT NULL, parent_name_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_F9EC095F35FE890 (parent_name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident_category (id INT AUTO_INCREMENT NOT NULL, parent_name_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_FE897DB235FE890 (parent_name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_gravity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demand_category ADD CONSTRAINT FK_F9EC095F35FE890 FOREIGN KEY (parent_name_id) REFERENCES demand_category (id)');
        $this->addSql('ALTER TABLE incident_category ADD CONSTRAINT FK_FE897DB235FE890 FOREIGN KEY (parent_name_id) REFERENCES incident_category (id)');
        $this->addSql('ALTER TABLE ticket ADD type_id INT DEFAULT NULL, ADD gravity_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C54C8C93 FOREIGN KEY (type_id) REFERENCES ticket_type (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3318332B1 FOREIGN KEY (gravity_id) REFERENCES ticket_gravity (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA36BF700BD FOREIGN KEY (status_id) REFERENCES ticket_status (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3C54C8C93 ON ticket (type_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3318332B1 ON ticket (gravity_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA36BF700BD ON ticket (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demand_category DROP FOREIGN KEY FK_F9EC095F35FE890');
        $this->addSql('ALTER TABLE incident_category DROP FOREIGN KEY FK_FE897DB235FE890');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3318332B1');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA36BF700BD');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C54C8C93');
        $this->addSql('DROP TABLE demand_category');
        $this->addSql('DROP TABLE incident_category');
        $this->addSql('DROP TABLE ticket_gravity');
        $this->addSql('DROP TABLE ticket_status');
        $this->addSql('DROP TABLE ticket_type');
        $this->addSql('DROP INDEX IDX_97A0ADA3C54C8C93 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3318332B1 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA36BF700BD ON ticket');
        $this->addSql('ALTER TABLE ticket DROP type_id, DROP gravity_id, DROP status_id');
    }
}
