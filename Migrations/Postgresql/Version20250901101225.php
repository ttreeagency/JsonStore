<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Initial Postgresql support
 */
final class Version20250901101225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial postgresql support';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE TABLE ttree_jsonstore_domain_model_document (persistence_object_identifier VARCHAR(40) NOT NULL, label VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, createdat TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updatedat TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, data jsonb NOT NULL, hash VARCHAR(40) NOT NULL, PRIMARY KEY(persistence_object_identifier))');
        $this->addSql('CREATE INDEX type ON ttree_jsonstore_domain_model_document (type)');
        $this->addSql('CREATE INDEX hash ON ttree_jsonstore_domain_model_document (hash)');
        $this->addSql('CREATE INDEX data ON ttree_jsonstore_domain_model_document USING GIN(data)');
        $this->addSql('CREATE INDEX createdat ON ttree_jsonstore_domain_model_document (createdat)');
        $this->addSql('CREATE INDEX updatedat ON ttree_jsonstore_domain_model_document (updatedat)');
        $this->addSql('COMMENT ON COLUMN ttree_jsonstore_domain_model_document.createdat IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN ttree_jsonstore_domain_model_document.updatedat IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN ttree_jsonstore_domain_model_document.data IS \'(DC2Type:flow_json_array)\'');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE ttree_jsonstore_domain_model_document');
    }
}
