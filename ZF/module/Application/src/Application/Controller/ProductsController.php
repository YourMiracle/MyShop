<?php
namespace Application\Controller;
use Application\Model\Products;
use Application\Model\Properties;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;
use Zend\Http\Request;
use Application\Model\Categories;
use Zend\Validator\File\Size;

class ProductsController extends Controller
{



    public $thisVar ;
    protected $productsTable;
    protected $propertiesTable;
    public function __construct($thisVar)
    {
        $this->thisVar = $thisVar;
    }


    public function getProductsTable()
    {
        if (!$this->productsTable) {
            $sm = $this->thisVar->getServiceLocator();

            $this->productsTable = $sm->get('Application\Model\ProductsTable');
        }
        return $this->productsTable;
    }

    public function getPropertiesTable()
    {
        if (!$this->propertiesTable) {
            $sm = $this->thisVar->getServiceLocator();

            $this->propertiesTable = $sm->get('Application\Model\PropertiesTable');
        }
        return $this->propertiesTable;
    }



    public function indexAction()
    {


//        var_dump(getcwd());exit;
        $id = $this->thisVar->params()->fromRoute('id');
//        var_dump($id);exit;
        return $this->render(['category_id'=>$id,'list'=> $this->getProductsTable()->getByCateries($id)]);
    }

    public function addAction()
    {




        $title = $this->thisVar->getRequest()->getPost('title');
        $costOff = $this->thisVar->getRequest()->getPost('costoff');
        $description = $this->thisVar->getRequest()->getPost('description');
        $categoryId = $this->thisVar->getRequest()->getPost('category_id');
        if($this->thisVar->getRequest()->isPost()){
            if (strlen($title) > 0) {

                $file    = $this->thisVar->getRequest()->getFiles('path');
//                var_dump($file);exit;
                $size = new Size(array('min'=>2000000));
                $model = new Products();
                $pathImg=null;
                if(!empty($file)){
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $adapter->setValidators(array($size), $file['name']);
                    $adapter->setDestination(getcwd().'/public/images/uploads');
                    $adapter->receive($file['path']);
                    $pathImg = stristr($adapter->getFileName('path'),'/images/uploads/');
                }


                $model->exchangeArray([
                    'title'=>$title,
                    'costoff'=>$costOff,
                    'description'=>$description,
                    'categories_id' => $categoryId,
                    'path'=> $pathImg
                ]);
               $this->getProductsTable()->saveProducts($model);

                return $this->thisVar->redirect()->toUrl('/success/products/index/'.$categoryId);
            }else{
                $id = $this->thisVar->params()->fromRoute('id');
                return $this->render(['error'=>'Введите название','category_id'=>$id]);
            }
        }else{
            $id = $this->thisVar->params()->fromRoute('id');
            return $this->render(['category_id'=>$id]);
        }






    }

    public function editAction(){
        $title = $this->thisVar->getRequest()->getPost('title');
        $costOff = $this->thisVar->getRequest()->getPost('costoff');
        $description = $this->thisVar->getRequest()->getPost('description');
            $categoryId = $this->thisVar->getRequest()->getPost('categories_id');
        $properties= [
           'Размер'=> $this->thisVar->getRequest()->getPost('size'),
        'Материал'=> $this->thisVar->getRequest()->getPost('material'),
        'Время года'=>$this->thisVar->getRequest()->getPost('time'),
        'Цвет'=>$this->thisVar->getRequest()->getPost('color'),
        ];




        if($this->thisVar->getRequest()->isPost()){
            if (strlen($title) > 0) {
                $id = $this->thisVar->getRequest()->getPost('id');


                $file    = $this->thisVar->getRequest()->getFiles('path');
                $size = new Size(array('min'=>2000000));
                $pathImg = null;
                if(!empty($file) and mb_strlen($file['name']) > 0) {
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $adapter->setValidators(array($size), $file['name']);
                    $adapter->setDestination(getcwd() . '/public/images/uploads');
                    $adapter->receive($file['path']);
                    $pathImg = stristr($adapter->getFileName('path'),'/images/uploads/');
                }else{
                    $data = $this->getProductsTable()->getProducts($id);
                    $pathImg = $data->path;
                }


                $model = new Products();
                $model->exchangeArray([
                    'title'=>$title,
                    'costoff'=>$costOff,
                    'description'=>$description,
                    'id'=> $id,
                    'categories_id' => $categoryId,
                    'path'=> $pathImg
                ]);
                $this->getProductsTable()->updateProducts($model);
                $this->getPropertiesTable()->delete($id);
                foreach($properties as $key => $value){
                    $model = new Properties();
                    $model->exchangeArray([
                        'type'=>$key,
                        'value'=>$value,
                        'product_id'=>$id,

                    ]);
                    $this->getPropertiesTable()->saveProps($model);
                }



                return $this->thisVar->redirect()->toUrl('/success/products/index/'.$categoryId);
            }else{
                return $this->render(['error'=>'Введите название']);
            }
        }else{
            $id = $this->thisVar->params()->fromRoute('id');
            $data = $this->getProductsTable()->getProducts($id);
            $properties = $this->getPropertiesTable()->fetchAll();
            $propsCurrent = [];
            foreach($properties as $v){
                $propsCurrent[$v->type] = $v->value;
            }



            return $this->render(['data'=>$data,'properties'=>$propsCurrent]);
        }
    }


    public function deleteAction(){
        $id = $this->thisVar->params()->fromRoute('id');
        $data = $this->getProductsTable()->getProducts($id);
        $this->getProductsTable()->delete($id);

        return $this->thisVar->redirect()->toUrl('/success/products/index/'.$data->categories_id);
    }
}
