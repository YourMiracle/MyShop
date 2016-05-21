<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Http\Request;

class CategoryController extends Controller
{



    public $thisVar ;
    protected $categoriesTable;
    
    public function __construct($thisVar)
    {
            $this->thisVar = $thisVar;
    }


    public function getCategoriesTable()
    {
        if (!$this->categoriesTable) {
            $sm = $this->thisVar->getServiceLocator();

            $this->categoriesTable = $sm->get('Application\Model\CategoriesTable');
        }
        return $this->categoriesTable;
    }


    public function indexAction()
    {
//        var_dump($this->getCategoriesTable()->fetchAll());

        return $this->render();
    }

    public function addAction()
    {

        $request = new Request();
        $title = $this->thisVar->getRequest()->getPost('title');
//        $record = mysql_query()
        if (strlen($title) > 0) {
            exit($title);


        }
        return $this->render();

    }
}