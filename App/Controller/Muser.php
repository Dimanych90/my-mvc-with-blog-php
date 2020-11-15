<?php


namespace App\Controller;

use Base\View;
use Base\Controller;

class Muser extends Controller
{
    public $view;




    public function userAction()
    {
        $this->_render = false;
        $this->_json_data = ["name" => "Guly", "age" => 30];
        $this->json();
    }

    public function indexAction()
    {
        echo 'This is index';
    }


}