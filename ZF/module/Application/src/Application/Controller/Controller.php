<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 15.05.16
 * Time: 21:38
 */

namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Controller extends AbstractActionController
{
    public function render($arrayData = []){
        
        $result = new ViewModel($arrayData);
        $url  = explode('/',$_SERVER['REQUEST_URI']);
        $result->setTemplate('application/'.$url[2].'/'.$url[3]);
        return $result;
        
    }
}