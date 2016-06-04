<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $categoriesTable;
    public function getCategoriesTable()
    {
        if (!$this->categoriesTable) {
            $sm = $this->getServiceLocator();
           
            $this->categoriesTable = $sm->get('Application\Model\CategoriesTable');
        }
        return $this->categoriesTable;
    }
    public function indexAction()
    {
        
        return new ViewModel(array(
            'categories' => $this->getCategoriesTable()->fetchAll(),
        ));
    }

    public function catalogAction(){

        return new ViewModel(array(
            'categories' => $this->getCategoriesTable()->fetchAll(),
        ));
    }
    public function aandqAction(){
        return new ViewModel();
    }
    public function reviewsAction(){
        return new ViewModel();
    }
    public function NikeAction(){
        return new ViewModel();
    }
}