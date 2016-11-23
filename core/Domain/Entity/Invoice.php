<?php namespace CleanPhp\Invoicer\Domain\Entity;

class Invoice extends AbstractEntity {

    protected $order;
    protected $invoiceDate;
    protected $total;

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     *
     * @return Invoice
     */
    public function setOrder( $order )
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * @param mixed $invoiceDate
     *
     * @return Invoice
     */
    public function setInvoiceDate( $invoiceDate )
    {
        $this->invoiceDate = $invoiceDate;
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
     * @return Invoice
     */
    public function setTotal( $total )
    {
        $this->total = $total;
        return $this;
    }
}