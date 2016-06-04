<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 15.04.16
 * Time: 19:26
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ProductsTable
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


    public function getByCateries($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('categories_id' => $id));

        return $rowset;
    }

    public function getProducts($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveProducts(Products $products)
    {
        $data = array(
            'title' => $products->title,
            'costoff' => $products->costoff,
            'description' => $products->description,
            'categories_id' => $products->categories_id,
            'path' => $products->path
        );


        $this->tableGateway->insert($data);


    }

    public function updateProducts(Products $products)
    {
        $data = array(
            'title' => $products->title,
            'costoff' => $products->costoff,
            'description' => $products->description,
            'categories_id' => $products->categories_id,
            'path' => $products->path
        );

        $id = (int)$products->id;

        $this->tableGateway->update($data, ['id' => $id]);

    }

    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => (int)$id));
    }

    public function getForClients($cat = null,$price = null)
    {

        $sqlSelect = $this->tableGateway->getSql()->select()
            ->join('categories', 'products.categories_id = categories.id', array('title_cat' => 'title', 'id_cat' => 'id'), 'left ');

        if(!is_null($cat)){
            $sqlSelect->where('products.categories_id = '. $cat);
        }
        if(!is_null($price)){
            $sqlSelect->where('products.costoff IN( '. $price .')');

        }
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();;

        $currentData = [];
        foreach ($resultSet as $key => $value) {

            $currentData[$value['id_cat']][] = $value;
        }

        return $currentData;
    }

    public function getPrices()
    {
        $sqlSelect = $this->tableGateway->getSql()->select()->columns(['costoff']);
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $data =  $statement->execute();
        $currentData = [];
        foreach ($data as $item) {
            $currentData[] = $item['costoff'];

        }

        $statement = array_unique($currentData);
        return $statement;

    }



}