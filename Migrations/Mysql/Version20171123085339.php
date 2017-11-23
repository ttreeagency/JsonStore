<?php
namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * A document table
 */
class Version20171123085339 extends AbstractMigration
{

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'A document table';
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on "mysql".');

        $this->addSql('CREATE TABLE ttree_jsonstore_domain_model_document (persistence_object_identifier VARCHAR(40) NOT NULL, `label` VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, createdat DATETIME NOT NULL, updatedat DATETIME NOT NULL, data LONGTEXT NOT NULL COMMENT \'(DC2Type:flow_json_array)\', INDEX type (type), INDEX createdat (createdat), INDEX updatedat (updatedat), INDEX UNIQ_D8BD6A06EA750E88CDE5729 (`label`, type), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on "mysql".');

        $this->addSql('DROP TABLE ttree_jsonstore_domain_model_document');
    }
}
