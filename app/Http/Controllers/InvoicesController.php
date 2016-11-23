<?php

namespace App\Http\Controllers;

use CleanPhp\Invoicer\Domain\Entity\Invoice;
use CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Domain\Service\InvoicingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoicesController extends Controller
{

    /**
     * @var \CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface
     */
    private $invoiceRepository;
    /**
     * @var \CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface
     */
    private $orderRepository;
    /**
     * @var \CleanPhp\Invoicer\Domain\Service\InvoicingService
     */
    private $invoicing;

    /**
     * InvoicesController constructor.
     *
     * @param \CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface $invoiceRepository
     * @param \CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface   $orderRepository
     * @param \CleanPhp\Invoicer\Domain\Service\InvoicingService              $invoicing
     */
    public function __construct(InvoiceRepositoryInterface $invoiceRepository,
                            OrderRepositoryInterface $orderRepository,
                                InvoicingService $invoicing)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->orderRepository = $orderRepository;
        $this->invoicing = $invoicing;
    }

    public function index()
    {
        $invoices = $this->invoiceRepository->getAll();
//        dd($invoices);
        return view('invoices/index', ['invoices' => $invoices]);
    }

    public function generate()
    {
        $invoices = $this->invoicing->generateInvoices();

        $this->invoiceRepository->begin();
        foreach ($invoices as $invoice) {
            $this->invoiceRepository->persist($invoice);
        }
        $this->invoiceRepository->commit();
        return view('invoices/generate', ['invoices' => $invoices]);
    }

    public function edit()
    {
        return view('invoices/new', [
            'orders' => $this->orderRepository->getUninvoicedOrders()
        ]);
    }

    public function view( $id )
    {
        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->getById($id);
        if (!$invoice) {
            return new Response('', 404);
        }
        return view('invoices/view', [
            'invoice' => $invoice,
            'order' => $invoice->getOrder()
        ]);
    }
}
