<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190624075953 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function getDescription() : string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     *
     * @throws DBALException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE name ('
                .'id INT AUTO_INCREMENT NOT NULL,'
                .'first_name VARCHAR(255) NOT NULL,'
                .'last_name VARCHAR(255) NOT NULL,'
                .'first_name_kana VARCHAR(255) NOT NULL,'
                .'last_name_kana VARCHAR(255) NOT NULL,'
                .'PRIMARY KEY(id)'
            .') DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'ALTER TABLE user '
                .'ADD name_id INT DEFAULT NULL,'
                .'ADD student_id INT NOT NULL,'
                .'ADD birthday DATE DEFAULT NULL,'
                .'CHANGE roles roles JSON NOT NULL'
        );

        $this->addSql(
            'ALTER TABLE user ADD CONSTRAINT FK_8D93D64971179CD6 FOREIGN KEY (name_id) REFERENCES name (id)'
        );

        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64971179CD6 ON user (name_id)');
    }

    /**
     * {@inheritdoc}
     *
     * @throws DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64971179CD6');
        $this->addSql('DROP TABLE name');
        $this->addSql('DROP INDEX UNIQ_8D93D64971179CD6 ON user');
        $this->addSql(
            'ALTER TABLE user '
                .'DROP name_id,'
                .'DROP student_id,'
                .'DROP birthday,'
                .'CHANGE roles roles LONGTEXT NOT NULL '
                .'COLLATE utf8mb4_bin'
        );
    }
}
