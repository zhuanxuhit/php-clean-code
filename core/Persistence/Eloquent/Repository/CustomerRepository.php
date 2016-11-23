<?php namespace CleanPhp\Invoicer\Persistence\Eloquent\Repository;


use CleanPhp\Invoicer\Domain\Entity\Customer;
use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;

class CustomerRepository extends AbstractEloquentRepository implements CustomerRepositoryInterface {
    protected $table = 'customers';

    function getModel()
    {
        return Customer::class;
    }
}