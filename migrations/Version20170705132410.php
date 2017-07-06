<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170705132410 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(45) NOT NULL, password VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, role VARCHAR(45) NOT NULL, first_name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quizzes (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_94DC9FB512469DE2 (category_id), INDEX IDX_94DC9FB5F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE results (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, quiz_id INT DEFAULT NULL, created_at DATETIME NOT NULL, score INT NOT NULL, finished TINYINT(1) NOT NULL, INDEX IDX_9FA3E414A76ED395 (user_id), INDEX IDX_9FA3E414853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answers (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, text LONGTEXT NOT NULL, correct TINYINT(1) NOT NULL, INDEX IDX_50D0C6061E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, text LONGTEXT NOT NULL, INDEX IDX_8ADC54D5853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result_answers (id INT AUTO_INCREMENT NOT NULL, result_id INT DEFAULT NULL, question_id INT DEFAULT NULL, answer_id INT DEFAULT NULL, INDEX IDX_32E944E27A7B643 (result_id), INDEX IDX_32E944E21E27F6BF (question_id), INDEX IDX_32E944E2AA334807 (answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quizzes ADD CONSTRAINT FK_94DC9FB512469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE quizzes ADD CONSTRAINT FK_94DC9FB5F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE results ADD CONSTRAINT FK_9FA3E414A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE results ADD CONSTRAINT FK_9FA3E414853CD175 FOREIGN KEY (quiz_id) REFERENCES quizzes (id)');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5853CD175 FOREIGN KEY (quiz_id) REFERENCES quizzes (id)');
        $this->addSql('ALTER TABLE result_answers ADD CONSTRAINT FK_32E944E27A7B643 FOREIGN KEY (result_id) REFERENCES results (id)');
        $this->addSql('ALTER TABLE result_answers ADD CONSTRAINT FK_32E944E21E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE result_answers ADD CONSTRAINT FK_32E944E2AA334807 FOREIGN KEY (answer_id) REFERENCES answers (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quizzes DROP FOREIGN KEY FK_94DC9FB512469DE2');
        $this->addSql('ALTER TABLE quizzes DROP FOREIGN KEY FK_94DC9FB5F675F31B');
        $this->addSql('ALTER TABLE results DROP FOREIGN KEY FK_9FA3E414A76ED395');
        $this->addSql('ALTER TABLE results DROP FOREIGN KEY FK_9FA3E414853CD175');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5853CD175');
        $this->addSql('ALTER TABLE result_answers DROP FOREIGN KEY FK_32E944E27A7B643');
        $this->addSql('ALTER TABLE result_answers DROP FOREIGN KEY FK_32E944E2AA334807');
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE result_answers DROP FOREIGN KEY FK_32E944E21E27F6BF');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE quizzes');
        $this->addSql('DROP TABLE results');
        $this->addSql('DROP TABLE answers');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE result_answers');
    }
}
