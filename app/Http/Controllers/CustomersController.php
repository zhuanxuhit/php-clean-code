<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewCustomerPost;
use CleanPhp\Invoicer\Domain\Entity\Customer;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use Illuminate\Http\RedirectResponse;
//use Illuminate\Support\Facades\Session;
//use Illuminate\Http\Request;

class CustomersController extends Controller
{

    /**
     * @var \CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * CustomersController constructor.
     *
     * @param \CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index(  )
    {
        $customers = $this->customerRepository->getAll();
        return view('customers/index', ['customers' => $customers]);
    }

    public function store(NewCustomerPost $request, $id = '')
    {
        $data = $request->all();
        $customer = $id ? $this->customerRepository->getById($id) : new Customer();

        $customer->setName($data['name'])->setEmail($data['email']);
        $this->customerRepository->persist($customer);
        return new RedirectResponse('/customers/edit/' . $customer->getId());
    }

    public function edit($id = '')
    {
        $customer = $id ? $this->customerRepository->getById($id) : new Customer();
        $viewModel['customer'] = $customer;
        return view('customers/new-or-edit', $viewModel);
    }
}
