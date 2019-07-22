<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190623160928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question_survey (id INT AUTO_INCREMENT NOT NULL, survey_id INT NOT NULL, content VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_AA02B4F4B3FE509D (survey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey (id INT AUTO_INCREMENT NOT NULL, assemble_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_AD5F9BFCD0E1956B (assemble_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer_question_survey (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_9776D37C1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer_survey (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, answer_question_survey_id INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_5FA6A15B1E27F6BF (question_id), INDEX IDX_5FA6A15B28D91646 (answer_question_survey_id), INDEX IDX_5FA6A15BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_survey ADD CONSTRAINT FK_AA02B4F4B3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFCD0E1956B FOREIGN KEY (assemble_id) REFERENCES assemble (id)');
        $this->addSql('ALTER TABLE answer_question_survey ADD CONSTRAINT FK_9776D37C1E27F6BF FOREIGN KEY (question_id) REFERENCES question_survey (id)');
        $this->addSql('ALTER TABLE answer_survey ADD CONSTRAINT FK_5FA6A15B1E27F6BF FOREIGN KEY (question_id) REFERENCES question_survey (id)');
        $this->addSql('ALTER TABLE answer_survey ADD CONSTRAINT FK_5FA6A15B28D91646 FOREIGN KEY (answer_question_survey_id) REFERENCES answer_question_survey (id)');
        $this->addSql('ALTER TABLE answer_survey ADD CONSTRAINT FK_5FA6A15BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE htag CHANGE assemble_id assemble_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE answer_question_survey DROP FOREIGN KEY FK_9776D37C1E27F6BF');
        $this->addSql('ALTER TABLE answer_survey DROP FOREIGN KEY FK_5FA6A15B1E27F6BF');
        $this->addSql('ALTER TABLE question_survey DROP FOREIGN KEY FK_AA02B4F4B3FE509D');
        $this->addSql('ALTER TABLE answer_survey DROP FOREIGN KEY FK_5FA6A15B28D91646');
        $this->addSql('DROP TABLE question_survey');
        $this->addSql('DROP TABLE survey');
        $this->addSql('DROP TABLE answer_question_survey');
        $this->addSql('DROP TABLE answer_survey');
        $this->addSql('ALTER TABLE htag CHANGE assemble_id assemble_id INT DEFAULT NULL');
    }
}
