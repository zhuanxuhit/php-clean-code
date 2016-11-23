<?php namespace CleanPhp\Invoicer\Persistence\Eloquent\Repository;

use CleanPhp\Invoicer\Domain\Entity\Invoice;
use CleanPhp\Invoicer\Domain\Entity\Order;
//use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\InvoiceRepositoryInterface;
use Illuminate\Database\DatabaseManager;

class InvoiceRepository extends AbstractEloquentRepository implements InvoiceRepositoryInterface   {

    protected $table = 'invoices';
    /**
     * @var \CleanPhp\Invoicer\Persistence\Eloquent\Repository\CustomerRepository
     */
    protected $orderRepository;

    /**
     * OrderRepository constructor.
     *
     * @param \Illuminate\Database\DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct($db);
        $this->orderRepository = new OrderRepository( $db);
    }

    function getModel()
    {
        return Invoice::class;
    }

    /**
     * @param $object
     * @param Invoice $entity
     */
    protected function hydrate( $object, $entity )
    {
//        dd($object);
        $customer = $this->orderRepository->getById( $object->order_id);
        $entity->setOrder($customer)->setTotal($object->total)
            ->setInvoiceDate(new \DateTime($object->invoice_date))
            ->setId($object->id);
    }

    /**
     * @param Invoice $entity
     * @return array
     */
    protected function extract( $entity )
    {
        $values = [];
        $values['order_id'] = $entity->getOrder()->getId();
        $values['total'] = $entity->getTotal();
        $values['invoice_date'] = $entity->getInvoiceDate()->format("Y-m-d");
        return $values;
    }
}