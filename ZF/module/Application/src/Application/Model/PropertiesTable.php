<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 15.04.16
 * Time: 19:26
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class PropertiesTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }



    public function getById($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('product_id' => $id));

        if (!$rowset) {
            throw new \Exception("Could not find row $id");
        }
        return $rowset;
    }
    public function saveProps(Properties $products)
    {
        $data = array(
            'type'  => $products->type,
            'value'=> $products->value,
            'product_id'=> $products->productId
        );



        $this->tableGateway->insert($data);




    }

    public function updateProps(Properties $products)
    {
        $data = array(
            'type'  => $products->type,
            'value'=> $products->value,
            'product_id'=> $products->productId
        );

        $id = (int) $products->id;

        $this->tableGateway->update($data,['id'=>$id]);

    }

    public function delete($id)
    {
        $this->tableGateway->delete(array('product_id' => (int) $id));
    }



}