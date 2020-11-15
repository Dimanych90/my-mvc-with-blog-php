<?php


namespace Base;


class Request
{
    private $_contrName;
    private $_actionName;
    private $_ip;
    private $_userAgent;

    public function __construct()
    {
        $servac = explode('/',$_SERVER['REQUEST_URI']);
//        var_dump($servac);die();
        $this->_contrName = $servac[1] ?? '';
        $this->_actionName = $servac[2] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getContrName()
    {
        return $this->_contrName;
    }

    /**
     * @param mixed|string $contrName
     */
    public function setContrName($contrName): void
    {
        $this->_contrName = $contrName;
    }

    /**
     * @return mixed|string
     */
    public function getActionName()
    {
        return $this->_actionName;
    }

    /**
     * @param mixed|string $actionName
     */
    public function setActionName($actionName): void
    {
        $this->_actionName = $actionName;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        $this->_ip = $_SERVER['SERVER_ADDR'];
        return $this->_ip;
    }



    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        $this->_userAgent = $_SERVER['HTTP_ACCEPT_ENCODING'];
        return $this->_userAgent;
    }


}