<?php namespace CleanPhp\Invoicer\Persistence\Eloquent\Repository;

use CleanPhp\Invoicer\Domain\Entity\AbstractEntity;
use CleanPhp\Invoicer\Domain\Repository\RepositoryInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

abstract class AbstractEloquentRepository implements RepositoryInterface {

    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $db;

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
        return $this->fromRaws( $rows, $entity );
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

    protected function camel_case_replace( $str )
    {
        return strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $str));
    }

    protected function extract( $entity )
    {
        $values = [];
        $methods =  get_class_methods($entity);
        foreach ($methods as $method){
            if ( starts_with($method,'get') && $method != 'getId') {
                $value = $entity->{$method}();
                $key  = $this->camel_case_replace(substr($method,3));
                if (is_object($value)){
                    $values[$key.'_id'] = call_user_func([$value,'getId']);
                }else {
                    $values[$key] = $value;
                }
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

    /**
     * @param $rows
     * @param $entity
     *
     * @return array
     */
    protected function fromRaws( $rows, $entity ):array
    {
        $entities = [];
        foreach ( $rows as $row ) {
            $object = new $entity;
            $this->hydrate( $row, $object );
            $entities[] = $object;
        }
        return $entities;
}
}