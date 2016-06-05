<?php
/**
 * Created by PhpStorm.
 * User: god
 * Date: 28.05.16
 * Time: 1:21
 */
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;
use Zend\Http\Request;
use Application\Model\Reviews;

class ReviewsController extends Controller
{
    public $thisVar;
    protected $reviewsTable;

    public function __construct($thisVar)
    {
        $this->thisVar = $thisVar;
    }


    public function getReviewsTable()
    {
        if (!$this->reviewsTable) {
            $sm = $this->thisVar->getServiceLocator();

            $this->reviewsTable = $sm->get('Application\Model\ReviewsTable');
        }
        return $this->reviewsTable;
    }


    public function indexAction()
    {


        return $this->render(['reviews' => $this->getReviewsTable()->fetchAll()]);
    }

    public function switchAction()
    {

        $id = $this->thisVar->params()->fromRoute('id');

          $check = $this->getReviewsTable()->switchReview($id);

        if($check){
            return $this->thisVar->redirect()->toUrl('/success/reviews/index');
        }


    }
    public function deleteAction(){
        $id = $this->thisVar->params()->fromRoute('id');
        $this->getReviewsTable()->delete($id);
        return $this->thisVar->redirect()->toUrl('/success/reviews/index');
    }
}
