<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705125146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket_beneficiairy (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_659778E6700047D2 (ticket_id), INDEX IDX_659778E6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user_category (user_id INT NOT NULL, user_category_id INT NOT NULL, INDEX IDX_84F5091A76ED395 (user_id), INDEX IDX_84F5091BB5D5477 (user_category_id), PRIMARY KEY(user_id, user_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket_beneficiairy ADD CONSTRAINT FK_659778E6700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket_beneficiairy ADD CONSTRAINT FK_659778E6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_user_category ADD CONSTRAINT FK_84F5091A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user_category ADD CONSTRAINT FK_84F5091BB5D5477 FOREIGN KEY (user_category_id) REFERENCES user_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3ED5CA9E6 ON ticket (service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_user_category DROP FOREIGN KEY FK_84F5091BB5D5477');
        $this->addSql('DROP TABLE ticket_beneficiairy');
        $this->addSql('DROP TABLE user_user_category');
        $this->addSql('DROP TABLE user_category');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3ED5CA9E6');
        $this->addSql('DROP INDEX IDX_97A0ADA3ED5CA9E6 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP service_id');
    }
}
