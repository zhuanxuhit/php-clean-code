<?php namespace CleanPhp\Invoicer\Persistence\Eloquent\Repository;

use CleanPhp\Invoicer\Domain\Entity\AbstractEntity;
use CleanPhp\Invoicer\Domain\Repository\RepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

abstract class AbstractEloquentRepository implements RepositoryInterface {

    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    private $db;

    protected $table;

    /**
     * AbstractEloquentRepository constructor.
     *
     * @param \Illuminate\Database\DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }



    public function getById( $id )
    {
        $entity = $this->getModel();
        //        $table = class_basename($entity);
        /** @var Collection $rows */
        $row = $this->db->connection()->table($this->table)->where('id',$id)->first();
        $object = new $entity;
        $this->hydrate($row,$object);
        return $object;
    }

    public function getAll()
    {
        $entity = $this->getModel();
//        $table = class_basename($entity);
        /** @var Collection $rows */
        $rows = $this->db->connection()->table($this->table)->get();

        $entities = [];
        foreach ($rows as $row){
            $object = new $entity;
            $this->hydrate($row,$object);
            $entities[] = $object;
        }
        return $entities;
    }

    /**
     * @param $object
     * @param $entity
     */
    protected function hydrate( $object, $entity )
    {
        $values = get_object_vars($object);
        foreach ($values as $key => $value){
            $method = 'set' . ucfirst($key);
            $entity->{$method}($value);
        }
    }

    protected function isGetMethod($method) {

    }

    protected function extract( $entity )
    {
        $values = [];
        $methods =  get_class_methods($entity);
        foreach ($methods as $method){
            if ( starts_with($method,'get') && $method != 'getId') {
                $values[lcfirst(substr($method,3))] = $entity->{$method}();
            }
        }
        return $values;
    }

    /**
     * @param  AbstractEntity $entity
     *
     * @throws \Exception
     */
    public function persist(  $entity )
    {
        $model = $this->getModel();
        if (!($entity instanceof $model)){
            throw new \Exception("type error");
        }

        if ($entity->getId()) {
            // update
            $this->db->connection()->table($this->table)->where('id',$entity->getId())
                ->update($this->extract($entity));
        }else {
            // insert
            //        $table = class_basename($entity);
            /** @var Collection $rows */
            $id = $this->db->connection()->table($this->table)->insertGetId($this->extract($entity));
            $entity->setId($id);
        }
    }

    public function begin()
    {
        $this->db->connection()->beginTransaction();
    }

    public function commit()
    {
        $this->db->connection()->commit();
    }

    abstract function getModel();
}