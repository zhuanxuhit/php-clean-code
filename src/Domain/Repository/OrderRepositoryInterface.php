<?php namespace CleanPhp\Invoicer\Domain\Repository;

interface OrderRepositoryInterface extends RepositoryInterface {
    public function getUninvoicedOrders();
}