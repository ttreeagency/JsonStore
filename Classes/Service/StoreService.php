<?php

namespace Ttree\JsonStore\Service;

use Ttree\JsonStore\Domain\Model\Document;
use Ttree\JsonStore\Domain\Repository\DocumentRepository;
use Ttree\JsonStore\Exception;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\PersistenceManagerInterface;
use Neos\Flow\Persistence\QueryInterface;
use Neos\Utility\Arrays;

/**
 * @Flow\Scope("singleton")
 */
class StoreService
{
    /**
     * @var DocumentRepository
     * @Flow\Inject
     */
    protected $documentRepository;

    /**
     * @var PersistenceManagerInterface
     * @Flow\Inject
     */
    protected $persistenceManager;

    /**
     * @param string $label
     * @param string $type
     * @param array $data
     * @return Document
     */
    public function add($label, $type, array $data)
    {
        $document = new Document($label, $type, $data);
        $this->documentRepository->add($document);
        $this->emitDocumentAdded($document);
        return $document;
    }

    /**
     * @param string $type
     * @param int $offset
     * @param int $limit
     * @param string $sortBy
     * @param string $sortDirection
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function paginate($type, $offset = 0, $limit = 50, $sortBy = 'createdAt', $sortDirection = QueryInterface::ORDER_DESCENDING)
    {
        return $this->documentRepository->paginateByType($type, $offset, $limit, $sortBy, $sortDirection);
    }

    /**
     * @param string $type
     */
    public function count($type)
    {
        return $this->documentRepository->countByType($type);
    }

    /**
     * @param string $identifier
     * @param array $data
     * @param string $label
     * @return Document
     * @throws Exception
     */
    public function update($identifier, array $data = null, $label = null)
    {
        $document = $this->documentRepository->findByIdentifier($identifier);
        if ($document === null) {
            throw new Exception(sprintf('Document with the given identifier (%s) not found', $identifier), 1511423944);
        }
        if ($label !== null) {
            $document->setLabel($label);
        }

        if (\is_array($data) && $data !== []) {
            $document->setData(Arrays::arrayMergeRecursiveOverrule($document->getData(), $data));
        } else if (\is_array($data) && $data === []) {
            $document->setData([]);
        }
        $this->documentRepository->update($document);
        $this->emitDocumentUpdated($document);
        return $document;
    }

    /**
     * @param string $identifier
     */
    public function remove($identifier)
    {
        $document = $this->documentRepository->findByIdentifier($identifier);
        $this->documentRepository->remove($document);
        $this->emitDocumentRemoved($document);
    }

    /**
     * @param Document $document
     * @return string
     */
    public function identifier(Document $document)
    {
        return $this->persistenceManager->getIdentifierByObject($document);
    }

    public function findByType($type)
    {
        return $this->documentRepository->findByType($type);
    }

    /**
     * @Flow\Signal
     */
    protected function emitDocumentAdded(Document $document)
    {

    }

    /**
     * @Flow\Signal
     */
    protected function emitDocumentUpdated(Document $document)
    {

    }

    /**
     * @Flow\Signal
     */
    protected function emitDocumentRemoved(Document $document)
    {

    }
}
