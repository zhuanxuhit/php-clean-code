<?php namespace CleanPhp\Invoicer\Domain\Entity;

class Order extends AbstractEntity {

    protected $customer;
    protected $orderNumber;
    protected $description;
    protected $total;

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     *
     * @return Order
     */
    public function setCustomer( $customer )
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param mixed $orderNumber
     *
     * @return Order
     */
    public function setOrderNumber( $orderNumber )
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return Order
     */
    public function setDescription( $description )
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     *
     * @return Order
     */
    public function setTotal( $total )
    {
        $this->total = $total;
        return $this;
    }

}