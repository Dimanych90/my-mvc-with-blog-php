<?php


namespace Base;
use Base\Controller;

class View
{

    private $error;

    /**
     * @return mixed
     */
    public function getError()
    {
       return $this->error = "Wrong login or password";

    }



    public function render($tpl)
    {
        ob_start();
        include $tpl;
        return ob_get_clean();
    }


}