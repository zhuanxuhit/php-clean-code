<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewOrderPost;
use CleanPhp\Invoicer\Domain\Entity\Order;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrdersController extends Controller
{

    /**
     * @var \CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface
     */
    private $orderRepository;
    /**
     * @var \CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * OrdersController constructor.
     *
     * @param \CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface    $orderRepository
     * @param \CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface $customerRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository,
            CustomerRepositoryInterface $customerRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customers = $this->orderRepository->getAll();
        return view('orders/index', ['orders' => $customers]);
    }

    public function store( NewOrderPost $request )
    {
        $order = new Order();
        $data = $request->all();

        $customer = $this->customerRepository->getById(array_get($data,'customer.id'));

        $order->setTotal($data['total'])
            ->setCustomer($customer)
            ->setDescription($data['description'])
            ->setOrderNumber($data['orderNumber']);
        $this->orderRepository->persist($order);
        return new RedirectResponse('/orders/view/' . $order->getId());
    }

    public function edit()
    {
        $viewModel = [];
        $order = new Order();
        $viewModel['customers'] = $this->customerRepository->getAll();
        $viewModel['order'] = $order;
        return view('orders/new', $viewModel);
    }

    public function view( $id )
    {
        $order = $this->orderRepository->getById($id);
        if (!$order) {
            return new Response('', 404);
        }
        return view('orders/view', ['order' => $order]);
    }
}
