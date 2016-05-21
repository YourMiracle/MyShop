<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 15.04.16
 * Time: 19:26
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoriesTable
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

    public function getCategories($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    public function saveCategories(Categories $categories)
    {
        $data = array(
            'title'  => $categories->title,
        );

        $id = (int) $categories->id;

            $this->tableGateway->insert($data);

    }

    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}