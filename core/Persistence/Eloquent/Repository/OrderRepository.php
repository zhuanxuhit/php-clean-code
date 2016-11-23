<?php namespace CleanPhp\Invoicer\Persistence\Eloquent\Repository;

use CleanPhp\Invoicer\Domain\Entity\Invoice;
use CleanPhp\Invoicer\Domain\Entity\Order;
//use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

/**
 * Class OrderRepository
 * @package CleanPhp\Invoicer\Persistence\Eloquent\Repository
 */
class OrderRepository extends AbstractEloquentRepository implements OrderRepositoryInterface  {

    protected $table = 'orders';
    /**
     * @var \CleanPhp\Invoicer\Persistence\Eloquent\Repository\CustomerRepository
     */
    protected $customerRepository;

    /**
     * OrderRepository constructor.
     *
     * @param \Illuminate\Database\DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct($db);
        $this->customerRepository = new CustomerRepository($db);
    }

    function getModel()
    {
        return Order::class;
    }

    /**
     * @return array
     */
    public function getUninvoicedOrders()
    {
        $entity = $this->getModel();
        //        $table = class_basename($entity);
        /** @var Collection $rows */
        $rows = $this->db->connection()
            ->table('orders')
            ->leftJoin('invoices','orders.id','=','invoices.order_id')
            ->select('orders.*')
            ->whereNull('invoices.id')
            ->get();
//        dd($rows);
        return $this->fromRaws( $rows, $entity );
    }

    /**
     * @param $object
     * @param Order $entity
     */
    protected function hydrate( $object, $entity )
    {
        $customer = $this->customerRepository->getById($object->customer_id);
        $entity->setCustomer($customer)->setOrderNumber($object->order_number)
            ->setTotal($object->total)->setDescription($object->description)
            ->setId($object->id);
    }
}