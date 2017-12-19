<?php

namespace Ttree\JsonStore\Service;

use Ttree\JsonStore\Domain\Repository\DocumentRepository;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class DocumentTypeManager
{
    /**
     * @var DocumentRepository
     * @Flow\Inject
     */
    protected $documentRepository;

    /**
     * @param string $type
     * @return bool
     */
    public function typeExists($type) {
        $types = $this->allTypes();
        return \in_array($type, $types);
    }

    /**
     * @return string[]
     */
    public function allTypes()
    {
        return $this->documentRepository->findAllTypes();
    }
}
