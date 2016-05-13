<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 15.04.16
 * Time: 17:07
 */

namespace Application\Model;

class Categories
{
    public $id;
    public $title;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
    }
}