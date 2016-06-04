<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class AnswerAndQuestionTable {
    
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

    public function switchQuestion($id){

        $data = $this->getQuestion($id);

        $this->tableGateway->update([
            'publish' => $data->publish ? 0 :1,
        ],
            ['id'=>$id]
        );
        return true;

    }

    public function getQuestion($id)
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

    public function saveQuestion(AnswerAndQuestion $question)
    {
        $data = array(
            'nickname'  => $question->nickname,
            'question'  => $question->question,
        );

        $this->tableGateway->insert($data);

    }
}