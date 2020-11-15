<?php


namespace Base;

use App\Model\User;

class Controller

{
    public $tpl;

    public $view;

    protected $_render = true;
    /** @var User */
    protected $USER;

    protected $_json_data = [];

    /**
     * @return bool
     */
    public function isRender(): bool
    {
        return $this->_render;
    }

    /**
     * @return array
     */
    public function json()
    {
//        header('Content-type: aplication\json');
        echo json_encode($this->_json_data);
    }

    public function preAction()
    {

    }

    /**
     * @param mixed $USER
     */
    public function setUSER(User $USER): void
    {
        $this->USER = $USER;
//        var_dump($this->getUSER());die();
    }

    /**
     * @return mixed
     */
    public function getUSER()
    {
        return $this->USER;

    }

    public function redirect($location)
    {
        throw new RedirectException($location);
    }

    public function p(string $key)
    {
        return htmlspecialchars($_REQUEST[$key] ?? '');
    }
}