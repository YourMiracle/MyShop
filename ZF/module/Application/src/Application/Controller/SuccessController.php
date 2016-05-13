<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\CategoriesTable;
class SuccessController extends AbstractActionController
{
   

    public function indexAction()
    {
        $this->layout('layout/admin');

        if (! $this->getServiceLocator()
            ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }
        $model =  new CategoriesTable;
        $date  =  $model->fetchAll();

        return new ViewModel(array('date'));
    }
}