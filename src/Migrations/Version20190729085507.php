<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190729085507 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     *
     * @throws DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE oauth2_access_token ('
                .'identifier CHAR(80) NOT NULL,'
                .'client VARCHAR(32) NOT NULL,'
                .'expiry DATETIME NOT NULL,'
                .'user_identifier VARCHAR(128) DEFAULT NULL,'
                .'scopes TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_scope)\','
                .'revoked TINYINT(1) NOT NULL,'
                .'INDEX IDX_454D9673C7440455 (client),'
                .'PRIMARY KEY(identifier)'
            .') DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE oauth2_authorization_code('
                .'identifier CHAR(80) NOT NULL,'
                .'client VARCHAR(32) NOT NULL,'
                .'expiry DATETIME NOT NULL,'
                .'user_identifier VARCHAR(128) DEFAULT NULL,'
                .'scopes TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_scope)\','
                .'revoked TINYINT(1) NOT NULL,'
                .'INDEX IDX_509FEF5FC7440455 (client),'
                .'PRIMARY KEY(identifier)'
            .') DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE oauth2_client ('
                .'identifier VARCHAR(32) NOT NULL,'
                .'secret VARCHAR(128) NOT NULL,'
                .'redirect_uris TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_redirect_uri)\','
                .'grants TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_grant)\','
                .'scopes TEXT DEFAULT NULL COMMENT \'(DC2Type:oauth2_scope)\','
                .'active TINYINT(1) NOT NULL,'
                .'PRIMARY KEY(identifier)'
            .') DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE oauth2_refresh_token ('
                .'identifier CHAR(80) NOT NULL,'
                .'access_token CHAR(80) DEFAULT NULL,'
                .'expiry DATETIME NOT NULL,'
                .'revoked TINYINT(1) NOT NULL,'
                .'INDEX IDX_4DD90732B6A2DD68 (access_token),'
                .'PRIMARY KEY(identifier)'
            .') DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'ALTER TABLE oauth2_access_token '
                .'ADD CONSTRAINT FK_454D9673C7440455 '
                .'FOREIGN KEY (client) REFERENCES oauth2_client (identifier)'
        );

        $this->addSql(
            'ALTER TABLE oauth2_authorization_code '
                .'ADD CONSTRAINT FK_509FEF5FC7440455 '
                .'FOREIGN KEY (client) REFERENCES oauth2_client (identifier)'
        );

        $this->addSql(
            'ALTER TABLE oauth2_refresh_token '
                .'ADD CONSTRAINT FK_4DD90732B6A2DD68 '
                .'FOREIGN KEY (access_token) REFERENCES oauth2_access_token (identifier) ON DELETE SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE oauth2_refresh_token DROP FOREIGN KEY FK_4DD90732B6A2DD68');
        $this->addSql('ALTER TABLE oauth2_access_token DROP FOREIGN KEY FK_454D9673C7440455');
        $this->addSql('ALTER TABLE oauth2_authorization_code DROP FOREIGN KEY FK_509FEF5FC7440455');
        $this->addSql('DROP TABLE oauth2_access_token');
        $this->addSql('DROP TABLE oauth2_authorization_code');
        $this->addSql('DROP TABLE oauth2_client');
        $this->addSql('DROP TABLE oauth2_refresh_token');
    }
}
