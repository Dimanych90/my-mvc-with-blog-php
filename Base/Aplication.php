<?php


namespace Base;


use App\Controller\Index;
use App\Model\User;
use Base\Model\Factory;
use Base\Request;
use Base\Controller;


class Aplication
{


    /** @var Context */
    private $_context;
//    /** @var Request */
//    private $_request;
//    /** @var Despetcher */
//    private $_despetcher;
//
//    public function __construct()
//    {
//
//    }


    public function ini()
    {

        $this->_context = Context::getInstance();

        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

        $dotenv->load();

        define("PRODUCTION", getenv("PRODUCTION"));
        $db = Db::instance();
        $request = new Request();
        $despetcher = new Despetcher();

        $this->_context->setDb($db);
        $this->_context->setDespetcher($despetcher);
        $this->_context->setRequest($request);

//        die();
        $this->iniUser();

    }

    public function iniUser()
    {
        $session = Session::instance();
        $userId = $session->getUserId();

        if ($userId) {
            if ($session->check()) {
                $user = Factory::getById(Factory::MODEL_USER, __FILE__, $userId);
                if ($user) {
                    $this->_context->setUser($user);
                }
            }
        }
    }

    public function run()
    {

        try {


            $this->ini();

            $this->_context->getDespetcher()->dispatch();
            $despetcher = $this->_context->getDespetcher();

            $routes = ['/login' => [Index::class, 'login'],
                '/register' => [Index::class, 'login']];

            if (isset($routes[$_SERVER["REQUEST_URI"]])) {
                $contrName = $routes[$_SERVER["REQUEST_URI"]][0];
                $actionName = $routes[$_SERVER["REQUEST_URI"]][1] . 'Action';
//                $contrName = new Index();
//                $actionName = $contrName->loginAction();
            } else {
                $contrName = "App\Controller\\" . $despetcher->getContrName();
//    var_dump($despetcher->getContrName());
                $actionName = $despetcher->getActionToken();
//            var_dump($contrName);die();
            }

            $contrObj = new $contrName;

//    var_dump($contrObj);

            $controller = new \Base\Controller();

            $view = new View();


            $user = Context::getInstance()->getUser();
            if ($user) {
                $contrObj->setUSER($user);
                $controller->setUSER($user);
            }

            $controller->preAction();

            $contrObj->view = $view;

            $contrObj->$actionName();
//            var_dump($contrObj);die();
            $tpl = "App/tamplates/" . $despetcher->getContrName() . '/' . $despetcher->getActionName() . '.phtml';


            if ($controller->isRender()) {
                $html = $view->render($tpl);
                echo $html;
//                if (!PRODUCTION){
//                    echo $this->_context->getDb()->getLog();
//                }
            }
        } catch (RedirectException $r) {
            header("Location: " . $r->getLocation());
        } catch (\Exception $e) {
            echo "Произошло исключение" . $e->getMessage();
        }
    }

}