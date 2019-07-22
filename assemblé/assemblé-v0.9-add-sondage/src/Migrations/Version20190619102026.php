<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190619102026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE assemble (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(500) NOT NULL, subject LONGTEXT NOT NULL, resume LONGTEXT DEFAULT NULL, prev_analyse LONGTEXT DEFAULT NULL, date_crea DATETIME DEFAULT NULL, date_upd DATETIME DEFAULT NULL, INDEX IDX_E08B344A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, assemble_id INT NOT NULL, name VARCHAR(520) NOT NULL, my_file VARCHAR(520) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_6354059D0E1956B (assemble_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE htag (id INT AUTO_INCREMENT NOT NULL, assemble_id INT DEFAULT NULL, name VARCHAR(520) NOT NULL, INDEX IDX_231E6E61D0E1956B (assemble_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, assemble_id INT NOT NULL, user_id INT NOT NULL, subject LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526CD0E1956B (assemble_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assemble ADD CONSTRAINT FK_E08B344A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059D0E1956B FOREIGN KEY (assemble_id) REFERENCES assemble (id)');
        $this->addSql('ALTER TABLE htag ADD CONSTRAINT FK_231E6E61D0E1956B FOREIGN KEY (assemble_id) REFERENCES assemble (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD0E1956B FOREIGN KEY (assemble_id) REFERENCES assemble (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_6354059D0E1956B');
        $this->addSql('ALTER TABLE htag DROP FOREIGN KEY FK_231E6E61D0E1956B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD0E1956B');
        $this->addSql('ALTER TABLE assemble DROP FOREIGN KEY FK_E08B344A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('DROP TABLE assemble');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE htag');
        $this->addSql('DROP TABLE comment');
    }
}
