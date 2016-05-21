<?php
namespace Application\Controller;


class SuccessController extends Controller
{


   
   

    public function indexAction()
    {

        $this->layout('layout/admin');

        if (! $this->getServiceLocator()
            ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }


        

        if(mb_strlen($this->params('controller_name')) > 0){
            $controllerName = ucfirst($this->params('controller_name'));
            $action = $this->params('action_name').'Action';
            $controller  = 'Application\Controller\\'.$controllerName.'Controller';
            $instance = new $controller($this);
            return $instance->$action();
        }else{
            return $this->redirect()->toUrl('/success/category/index');
        }

        
    }
    

}