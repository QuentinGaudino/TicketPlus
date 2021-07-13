<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210713065408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_user_category DROP FOREIGN KEY FK_84F5091BB5D5477');
        $this->addSql('DROP TABLE user_category');
        $this->addSql('DROP TABLE user_user_category');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3ED5CA9E6');
        $this->addSql('DROP INDEX IDX_97A0ADA3ED5CA9E6 ON ticket');
        $this->addSql('ALTER TABLE ticket ADD author_id INT NOT NULL, ADD support_assign_id INT DEFAULT NULL, CHANGE service_id support_technician_assign_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3B811F30E FOREIGN KEY (support_technician_assign_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A28C2FE7 FOREIGN KEY (support_assign_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3F675F31B ON ticket (author_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3B811F30E ON ticket (support_technician_assign_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A28C2FE7 ON ticket (support_assign_id)');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, DROP mail');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_user_category (user_id INT NOT NULL, user_category_id INT NOT NULL, INDEX IDX_84F5091A76ED395 (user_id), INDEX IDX_84F5091BB5D5477 (user_category_id), PRIMARY KEY(user_id, user_category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_user_category ADD CONSTRAINT FK_84F5091A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user_category ADD CONSTRAINT FK_84F5091BB5D5477 FOREIGN KEY (user_category_id) REFERENCES user_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3F675F31B');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3B811F30E');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A28C2FE7');
        $this->addSql('DROP INDEX IDX_97A0ADA3F675F31B ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3B811F30E ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3A28C2FE7 ON ticket');
        $this->addSql('ALTER TABLE ticket ADD service_id INT DEFAULT NULL, DROP author_id, DROP support_technician_assign_id, DROP support_assign_id');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3ED5CA9E6 ON ticket (service_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD mail VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP email, DROP roles');
    }
}
