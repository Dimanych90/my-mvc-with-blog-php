<?php


namespace Base;


use App\Controller\Index;

class Despetcher
{

    const DEFAULT_NAME = 'index';
    const DEFAULT_ACTION = 'index';

    private $_contrName;
    private $_actionName;


    public function dispatch()
    {
        $req = Context::getInstance()->getRequest();

        $contrName = $req->getContrName();
        $actionName = $req->getActionName();

        if (!$contrName) {
            $this->_contrName = self::DEFAULT_NAME;
        } else {
            $this->_contrName = ucfirst(strtolower($contrName));
        }
        if (!$actionName) {
            $this->_actionName = self::DEFAULT_ACTION;
        } else {
            $this->_actionName = strtolower($actionName);
        }
    }


    /**
     * @return mixed
     */
    public function getContrName()
    {
        return $this->_contrName;
    }

    /**
     * @param mixed $contrName
     */
    public function setContrName($contrName): void
    {
        $this->_contrName = $contrName;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->_actionName;
    }

    public function getActionToken()
    {
        return $this->_actionName . 'Action';
    }

    /**
     * @param mixed $actionName
     */
    public function setActionName($actionName): void
    {
        $this->_actionName = $actionName;
    }


}