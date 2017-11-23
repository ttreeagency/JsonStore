<?php

namespace Ttree\JsonStore\Domain\Model;

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 * @ORM\Table(
 *    indexes={
 *      @ORM\Index(name="type",columns={"type"}),
 *      @ORM\Index(name="hash",columns={"hash"}),
 *      @ORM\Index(name="createdat",columns={"createdat"}),
 *      @ORM\Index(name="updatedat",columns={"updatedat"})
 *    }
 * )
 */
class Document
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var \DateTimeImmutable
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="flow_json_array")
     * @var array<mixed>
     */
    protected $data = [];

    /**
     * @var string
     * @ORM\Column(length=40)
     */
    protected $hash;

    /**
     * @param string $label
     * @param string $type
     * @param array $data
     */
    public function __construct($label, $type, array $data)
    {
        $this->label = $label;
        $this->type = $type;
        $this->data = $data;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = $this->createdAt;
        $this->updateHash();
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->updatedAt = new \DateTimeImmutable();
        $this->label = $label;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->updatedAt = new \DateTimeImmutable();
        $this->data = $data;
        $this->updateHash();
    }

    protected function updateHash()
    {
        $this->hash = (string)(new DocumentHash($this->data));
    }

}
