<?php namespace CleanPhp\Invoicer\Domain\Service;

use CleanPhp\Invoicer\Domain\Entity\Invoice;
use CleanPhp\Invoicer\Domain\Factory\InvoiceFactory;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;

class InvoicingService {

    /**
     * @var \CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface
     */
    private $orderRepository;
    /**
     * @var \CleanPhp\Invoicer\Domain\Factory\InvoiceFactory
     */
    private $factory;

    /**
     * InvoicingService constructor.
     *
     * @param \CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface $orderRepository
     * @param \CleanPhp\Invoicer\Domain\Factory\InvoiceFactory              $factory
     */
    public function __construct(OrderRepositoryInterface $orderRepository, InvoiceFactory $factory)
    {
        $this->orderRepository = $orderRepository;
        $this->factory = $factory;
    }

    /**
     * @return array
     */
    public function generateInvoices()
    {
        $orders = $this->orderRepository->getUninvoicedOrders();
        $invoices = [];
        foreach ($orders as $order){
            $invoices[] = $this->factory->createFromOrder($order);
        }
        return $invoices;
    }
}