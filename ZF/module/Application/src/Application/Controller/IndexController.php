<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\AnswerAndQuestion;
use Symfony\Component\Console\Question\Question;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Reviews;

class IndexController extends AbstractActionController
{
    protected $reviewsTable;
    protected $categoriesTable;
    protected $answerQuestionTable;

    public function getCategoriesTable()
    {
        if (!$this->categoriesTable) {
            $sm = $this->getServiceLocator();
           
            $this->categoriesTable = $sm->get('Application\Model\CategoriesTable');
        }
        return $this->categoriesTable;
    }

    public function getReviewsTable()
    {
        if (!$this->reviewsTable) {
            $sm = $this->getServiceLocator();

            $this->reviewsTable = $sm->get('Application\Model\ReviewsTable');
        }
        return $this->reviewsTable;
    }
    public function getQuestionTable()
    {
        if (!$this->answerQuestionTable) {
            $sm = $this->getServiceLocator();

            $this->answerQuestionTable = $sm->get('Application\Model\AnswerAndQuestionTable');
        }
        return $this->answerQuestionTable;
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
    public function answerQuestionAction(){
        return new ViewModel();
    }
    public function reviewsAction(){
        
        return new ViewModel([
            'reviews' => $this->getReviewsTable()->getBuyPublish(),
        ]);

    }
    public function writeReviewsAction(){
        $data = [
            'nickname' => $this->getRequest()->getPost('nickname') ,
            'reviews' => $this->getRequest()->getPost('reviews')
        ];
        $model = new Reviews();
        $model->exchangeArray($data);
        $this->getReviewsTable()->saveReviews($model);
        return $this->redirect()->toUrl('/reviews');
    }
    public function writeQuestionAction(){
        $data = [
            'nickname' => $this->getRequest()->getPost('nickname') ,
            'question' => $this->getRequest()->getPost('question')
        ];
        $model = new AnswerAndQuestion();
        $model->exchangeArray($data);
        $this->getQuestionTable()->saveQuestion($model);
        return $this->redirect()->toUrl('/answer_question');
    }
}