<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 15.04.16
 * Time: 17:07
 */

namespace Application\Model;

class Properties
{
    public $id;
    public $type;
    public $value;
    public $productId;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->type  = (!empty($data['type'])) ? $data['type'] : null;
        $this->value  = (!empty($data['value'])) ? $data['value'] : null;
        $this->productId  = (!empty($data['product_id'])) ? $data['product_id'] : null;

    }


}