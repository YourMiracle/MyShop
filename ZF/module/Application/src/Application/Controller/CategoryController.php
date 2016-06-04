<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;
use Zend\Http\Request;
use Application\Model\Categories;

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

        return $this->render(['items' => $this->getCategoriesTable()->fetchAll()]);
    }

    public function addAction()
    {

        $title = $this->thisVar->getRequest()->getPost('title');
        if($this->thisVar->getRequest()->isPost()){
            if (strlen($title) > 0) {
                $model = new Categories();
                $model->exchangeArray(['title'=>$title]);
                $this->getCategoriesTable()->saveCategories($model);

                return $this->thisVar->redirect()->toUrl('/success/category/index');
            }else{
                return $this->render(['error'=>'Введите название']);
            }
        }else{
            return $this->render();
        }



    }

    public function editAction(){
        $title = $this->thisVar->getRequest()->getPost('title');
        if($this->thisVar->getRequest()->isPost()){
            if (strlen($title) > 0) {
                $id = $this->thisVar->getRequest()->getPost('id');
                $model = new Categories();
                $model->exchangeArray(['title'=>$title,'id'=>$id]);
                $this->getCategoriesTable()->update($model);
                return $this->thisVar->redirect()->toUrl('/success/category/index');
            }else{
                return $this->render(['error'=>'Введите название']);
            }
        }else{
            $id = $this->thisVar->params()->fromRoute('id');
            $data = $this->getCategoriesTable()->getCategories($id);
            return $this->render(['data'=>$data]);
        }
    }


    public function deleteAction(){
        $id = $this->thisVar->params()->fromRoute('id');
        $this->getCategoriesTable()->delete($id);
        return $this->thisVar->redirect()->toUrl('/success/category/index');
    }


}
