<?php namespace CleanPhp\Invoicer\Domain\Entity;

class Customer extends AbstractEntity {

    protected $name;
    protected $email;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $name
     *
     * @return Customer
     */
    public function setName( $name )
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $email
     *
     * @return Customer
     */
    public function setEmail( $email )
    {
        $this->email = $email;
        return $this;
    }

}