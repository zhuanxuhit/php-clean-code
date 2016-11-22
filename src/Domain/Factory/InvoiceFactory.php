<?php namespace CleanPhp\Invoicer\Domain\Factory;

use CleanPhp\Invoicer\Domain\Entity\Invoice;
use CleanPhp\Invoicer\Domain\Entity\Order;

class InvoiceFactory {

    /**
     * @param \CleanPhp\Invoicer\Domain\Entity\Order $order
     *
     * @return \CleanPhp\Invoicer\Domain\Entity\Invoice
     */
    public function createFromOrder( Order $order )
    {
        $invoice = new Invoice();
        $invoice->setTotal( $order->getTotal() )
            ->setOrder( $order )
            ->setInvoiceDate( new \DateTime() );
        return $invoice;
    }
}