<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210706065002 extends AbstractMigration
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
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, type_id INT DEFAULT NULL, gravity_id INT DEFAULT NULL, status_id INT DEFAULT NULL, incident_category_id INT DEFAULT NULL, demand_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, creation_date DATE NOT NULL, incident_date DATE DEFAULT NULL, INDEX IDX_97A0ADA3ED5CA9E6 (service_id), INDEX IDX_97A0ADA3C54C8C93 (type_id), INDEX IDX_97A0ADA3318332B1 (gravity_id), INDEX IDX_97A0ADA36BF700BD (status_id), INDEX IDX_97A0ADA3AE6ED38F (incident_category_id), INDEX IDX_97A0ADA379DFB95E (demand_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_beneficiairy (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_659778E6700047D2 (ticket_id), INDEX IDX_659778E6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_gravity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_message (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, user_id INT DEFAULT NULL, value LONGTEXT NOT NULL, time_stamp DATETIME NOT NULL, INDEX IDX_BA71692D700047D2 (ticket_id), INDEX IDX_BA71692DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, avatar_link VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demand_category ADD CONSTRAINT FK_F9EC095F35FE890 FOREIGN KEY (parent_name_id) REFERENCES demand_category (id)');
        $this->addSql('ALTER TABLE incident_category ADD CONSTRAINT FK_FE897DB235FE890 FOREIGN KEY (parent_name_id) REFERENCES incident_category (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C54C8C93 FOREIGN KEY (type_id) REFERENCES ticket_type (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3318332B1 FOREIGN KEY (gravity_id) REFERENCES ticket_gravity (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA36BF700BD FOREIGN KEY (status_id) REFERENCES ticket_status (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3AE6ED38F FOREIGN KEY (incident_category_id) REFERENCES incident_category (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA379DFB95E FOREIGN KEY (demand_category_id) REFERENCES demand_category (id)');
        $this->addSql('ALTER TABLE ticket_beneficiairy ADD CONSTRAINT FK_659778E6700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket_beneficiairy ADD CONSTRAINT FK_659778E6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_message ADD CONSTRAINT FK_BA71692D700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket_message ADD CONSTRAINT FK_BA71692DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demand_category DROP FOREIGN KEY FK_F9EC095F35FE890');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA379DFB95E');
        $this->addSql('ALTER TABLE incident_category DROP FOREIGN KEY FK_FE897DB235FE890');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3AE6ED38F');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3ED5CA9E6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ED5CA9E6');
        $this->addSql('ALTER TABLE ticket_beneficiairy DROP FOREIGN KEY FK_659778E6700047D2');
        $this->addSql('ALTER TABLE ticket_message DROP FOREIGN KEY FK_BA71692D700047D2');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3318332B1');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA36BF700BD');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C54C8C93');
        $this->addSql('ALTER TABLE ticket_beneficiairy DROP FOREIGN KEY FK_659778E6A76ED395');
        $this->addSql('ALTER TABLE ticket_message DROP FOREIGN KEY FK_BA71692DA76ED395');
        $this->addSql('DROP TABLE demand_category');
        $this->addSql('DROP TABLE incident_category');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_beneficiairy');
        $this->addSql('DROP TABLE ticket_gravity');
        $this->addSql('DROP TABLE ticket_message');
        $this->addSql('DROP TABLE ticket_status');
        $this->addSql('DROP TABLE ticket_type');
        $this->addSql('DROP TABLE user');
    }
}
