<?php

namespace Ttree\JsonStore\Domain\Repository;

use Ttree\JsonStore\Domain\Model\Document;
use Neos\Flow\Persistence\QueryInterface;
use Neos\Flow\Persistence\Repository;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class DocumentRepository extends Repository
{
    protected $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING
    ];

    /**
     * @param string $identifier
     * @return Document
     */
    public function findByIdentifier($identifier)
    {
        return parent::findByIdentifier($identifier);
    }

    public function paginateByType($type, $offset = 0, $limit = 50, $sortBy = 'createdAt', $sortDirection = QueryInterface::ORDER_DESCENDING)
    {
        $query = $this->createQuery();

        $query->matching($query->equals('type', $type));
        $query->setOffset($offset);
        $query->setLimit($limit);

        $query->setOrderings([
            $sortBy => $sortDirection
        ]);

        return $query->execute();
    }

    public function countByType($type)
    {
        $query = $this->createQuery();

        $query->matching($query->equals('type', $type));

        return $query->count();
    }
}
