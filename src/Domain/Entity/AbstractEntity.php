<?php namespace CleanPhp\Invoicer\Domain\Entity;

abstract class AbstractEntity {
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return $this
     */
    public function setId( $id )
    {
        $this->id = $id;
        return $this;
    }

}