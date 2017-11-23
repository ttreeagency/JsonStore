<?php
namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add document hash
 */
class Version20171123093932 extends AbstractMigration
{

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Add document hash';
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on "mysql".');

        $this->addSql('ALTER TABLE ttree_jsonstore_domain_model_document ADD hash VARCHAR(40) NOT NULL');
        $this->addSql('CREATE INDEX hash ON ttree_jsonstore_domain_model_document (hash)');
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on "mysql".');

        $this->addSql('DROP INDEX hash ON ttree_jsonstore_domain_model_document');
        $this->addSql('DROP INDEX UNIQ_D8BD6A06EA750E88CDE5729 ON ttree_jsonstore_domain_model_document');
        $this->addSql('ALTER TABLE ttree_jsonstore_domain_model_document DROP hash');
    }
}
