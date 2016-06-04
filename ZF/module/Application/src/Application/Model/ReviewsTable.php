<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 28.05.16
 * Time: 0:40
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ReviewsTable
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
    
    public function switchReview($id){
        
        $data = $this->getReviews($id);
        
        $this->tableGateway->update([
            'publish' => $data->publish ? 0 :1,
        ],
            ['id'=>$id]
        );
        return true;
        
    }

    public function getReviews($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    public function getBuyPublish(){

        $resultSet = $this->tableGateway->select(['publish' => 1]);
        return $resultSet;
    }
    public function saveReviews(Reviews $reviews)
    {
        $data = array(
            'nickname'  => $reviews->nickname,
            'reviews'  => $reviews->reviews,
        );

        $this->tableGateway->insert($data);

    }
   
}
