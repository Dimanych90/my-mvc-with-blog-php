<?php

namespace App\Controller;

use Base\Controller;
use App\Model\User;
use Base\ControllerUser;
use Base\Db;
use Base\Exception;
use Base\Model\Factory;
use Base\View;
use App\Model\Posts;

class Index extends ControllerUser

{

    public $view;

    private $id;


    public function indexAction()
    {
        $users = [];

        $posts = Factory::getList(Factory::MODEL_POSTS, __METHOD__, 10, [], 'id DESC');
        if ($posts) {
            $userIds = array_map(function (Posts $post) {

                return $post->getUserId();
            }, $posts);
            $users = Factory::getByIds(Factory::MODEL_USER, __METHOD__, $userIds);
        }

        $this->view->posts = $posts;
        $this->view->users = $users;

//        $this->tpl = 'index.phtml';
//        $this->preAction();

    }

    public function sendPostAction()
    {

//        $this->indexAction();
        $message = $this->p('message') ?? '';

//        var_dump("here");

        $model = new Posts();
//        $user = new User();

//        die();
        /** App/Model/User */
        if (isset($this->USER)) {
            $model->initByData([
                'user_id' => $this->USER->getId(),
                'message' => $message
            ]);
        }

        $model->insert();
//        $this->indexAction();
        $this->redirect('/');

    }

    public function registerAction()
    {


    }

    public function registeredAction()
    {

        $model = new User();

        $model->fetchOne();
        $db = Db::instance();
//        var_dump($db->getFetch());

//        $this->redirect('/Index/register');


    }

    public function insertAction()
    {

        $model = new User();
        $model->insert();
//        $db = Db::instance();
//        var_dump($db->getFetch());
        $this->redirect('/Index/register');

    }

    public function createUserAction()
    {
        $login = $this->p('login') ?? '';
        $password = $this->p('password') ?? '';
        $email = $this->p('email') ?? '';

        $model = new User();
        $model->initByData([
            'login' => $login,
            'password' => $password,
            'email' => $email
        ]);
        if ($model->userauthorize()) {
            $this->redirect('/Index/register');
        }else{
            $model->insert();
            $this->redirect("/Index/register");
        }


//        $this->redirect('/');

    }

    public function loginAction()
    {
        $login = $this->p('login') ?? '';
        $password = $this->p('password') ?? '';
        $email = $this->p('email') ?? '';

        $model = new User();
        $model->initByData([
            'login' => $login,
            'password' => $password,
            'email' => $email
        ]);
        $model->userauthorize();
        try {
            $model->userauthorize();
            if (!$model->userauthorize()) {
                $error = 'Wrong login or password';
            }
        } catch (\Exception $e) {
            $error = "The falt of server";
//            trigger_error($e->getMessage());
            $success = false;
        }

        if ($model->userauthorize()) {
            $this->redirect('/');
        } else {
            $this->redirect('/Index/register');
//            $this->view->error = $error;
//            $this->tpl = 'register.phtml';
        }


    }


}