<?php

namespace Ttree\JsonStore\Domain\Repository;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query;
use Ttree\JsonStore\Domain\Model\Document;
use TYPO3\Flow\Persistence\QueryInterface;
use TYPO3\Flow\Persistence\Repository;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class DocumentRepository extends Repository
{
    /**
     * @var ObjectManager
     * @Flow\Inject
     */
    protected $entityManager;

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

    public function findAllTypes()
    {
        /** @var Query $query */
        $query = $this->entityManager->createQuery('SELECT DISTINCT d.type FROM Ttree\JsonStore\Domain\Model\Document d');
        return \array_map(function ($row) {
            return $row['type'];
        }, $query->execute());
    }
}
