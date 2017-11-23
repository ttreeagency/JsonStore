<?php

namespace Ttree\JsonStore\Domain\Model;

class DocumentHash
{
    /**
     * @var string
     */
    protected $hash;

    public function __construct(array $data)
    {
        $this->updateHash($data);
    }

    public function __toString()
    {
        return $this->hash;
    }

    protected function updateHash(array $data)
    {
        $this->hash = \sha1(\json_encode($data));
    }

}
