<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 28.05.16
 * Time: 0:29
 */
namespace Application\Model;

class Reviews
{
    public $id;
    public $nickname;
    public $reviews;
    public $publish;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->reviews  = (!empty($data['reviews'])) ? $data['reviews'] : null;
        $this->nickname = (!empty($data['nickname'])) ? $data['nickname'] : null;
        $this->publish = (!empty($data['publish'])) ? $data['publish'] : null;
    }
}