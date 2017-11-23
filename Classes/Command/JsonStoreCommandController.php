<?php
namespace Ttree\JsonStore\Command;

use Ttree\JsonStore\Domain\Model\Document;
use Ttree\JsonStore\Domain\Model\DocumentHash;
use Ttree\JsonStore\Service\StoreService;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;

class JsonStoreCommandController extends CommandController
{
    /**
     * @var StoreService
     * @Flow\Inject
     */
    protected $store;

    /**
     * Test the store (dev)
     */
    public function testCommand()
    {
        $type = 'ch.ttree.store.document.test.v1';
        $label = 'Test';
        $document = $this->store->add($label, 'ch.ttree.store.document.test.v1', [
            'title' => $label,
            'firstName' => 'Dominique',
            'lastName' => 'Feyer',
            'username' => 'dfeyer',
            'email' => 'dfeyer@ttree.ch',
        ]);

        $this->outputLine('Document created: ' . $document->getLabel());

        $identifier = $this->store->identifier($document);
        $this->store->update($identifier, [
            'username' => 'dominique.feyer',
            'usernameChanged' => true
        ]);

        $this->outputLine('Document updated: ' . $document->getLabel());

        $label = 'New label';
        $this->store->update($identifier, null, $label);

        $this->outputLine('Document label updated: ' . $document->getLabel());

        $this->outputLine();
        $this->outputLine('<info>Document pagination ...</info>');

        $count = $this->store->count($type);
        $documentPerPage = 10;

        $this->outputLine('  <comment>Number of document:</comment> ' . $count);
        $this->outputLine('  <comment>Document per pages:</comment> ' . $documentPerPage);

        $pages = \ceil($count / $documentPerPage);

        for ($i = 0; $i < $pages; $i++) {
            $offset = $i * $documentPerPage;
            /** @var Document $document */
            $this->outputLine();
            $this->outputLine('  <info>Page #</info>' . ($i + 1));
            foreach ($this->store->paginate($type, $offset, $documentPerPage) as $document) {
                $this->outputLine('  - <comment>' . $document->getLabel() . '</comment> @ ' . $document->getCreatedAt()->format('d.m.Y H:i'));
            }
        }

    }
}
