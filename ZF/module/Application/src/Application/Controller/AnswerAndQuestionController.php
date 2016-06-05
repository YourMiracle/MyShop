<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;
use Zend\Http\Request;
use Application\Model\AnswerAndQuestion;

class AnswerAndQuestionController extends Controller {
    public $thisVar;
    protected $questionTable;

    public function __construct($thisVar)
    {
        $this->thisVar = $thisVar;
    }


    public function getQuestionTable()
    {
        if (!$this->questionTable) {
            $sm = $this->thisVar->getServiceLocator();

            $this->questionTable = $sm->get('Application\Model\AnswerAndQuestionTable');
        }
        return $this->questionTable;
    }


    public function indexAction()
    {


        return $this->render(['question' => $this->getQuestionTable()->fetchAll()]);
    }

    public function switchAction()
    {

        $id = $this->thisVar->params()->fromRoute('id');
        

        $check = $this->getQuestionTable()->switchQuestion($id);

        if($check){
            return $this->thisVar->redirect()->toUrl('/success/answerAndQuestion/index');
        }

    }
    public function deleteAction(){
        $id = $this->thisVar->params()->fromRoute('id');
        $this->getQuestionTable()->delete($id);
        return $this->thisVar->redirect()->toUrl('/success/answerAndQuestion/index');
    }

}