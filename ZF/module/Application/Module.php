<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\Categories;
use Application\Model\CategoriesTable;
use Application\Model\Reviews;
use Application\Model\ReviewsTable;
use Application\Model\AnswerAndQuestion;
use Application\Model\AnswerAndQuestionTable;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Application\Model\MyAuthStorage' => function($sm){
                    return new \Application\Model\MyAuthStorage('zf_tutorial');
                },
                'AuthService' => function($sm) {
                    //My assumption, you've alredy set dbAdapter
                    //and has users table with columns : user_name and pass_word
                    //that password hashed with md5
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter,
                        #'users','username','password', 'MD5(?)');
                        'users','username','password');
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($sm->get('Application\Model\MyAuthStorage'));
                    return $authService;
                },
                'Application\Model\CategoriesTable' =>  function($sm) {
                    $tableGateway = $sm->get('CategoriesTableGateway');
                    $table = new CategoriesTable($tableGateway);
                    return $table;
                },
                'CategoriesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Categories());
                    return new TableGateway('categories', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ReviewsTable' =>  function($sm) {
                    $tableGateway = $sm->get('ReviewsTableGateway');
                    $table = new ReviewsTable($tableGateway);
                    return $table;
                },
                'ReviewsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Reviews());
                    return new TableGateway('reviews', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\AnswerAndQuestionTable' =>  function($sm) {
                    $tableGateway = $sm->get('AnswerAndQuestionTableGateway');
                    $table = new AnswerAndQuestionTable($tableGateway);
                    return $table;
                },
                'AnswerAndQuestionTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new AnswerAndQuestion());
                    return new TableGateway('answer_question', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
