<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 15.04.16
 * Time: 17:07
 */

namespace Application\Model;

class Products
{
    public $id;
    public $title;
    public $description;
    public $categories_id;
    public $costoff;
    public $path;
    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
        $this->description  = (!empty($data['description'])) ? $data['description'] : null;
        $this->categories_id  = (!empty($data['categories_id'])) ? $data['categories_id'] : null;
        $this->costoff  = (!empty($data['costoff'])) ? $data['costoff'] : null;
        $this->path  = (!empty($data['path'])) ? $data['path'] : null;
    }


}