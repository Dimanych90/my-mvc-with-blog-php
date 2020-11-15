<?php


namespace Base;


class Context
{
    private $_db;
    private $_despetcher;
    private $_request;
    private $_user;
    private static $_instance;


    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->_user = $user;
    }




    public function __construct()
    {
    }



    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        {
            return self::$_instance;
        }
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }


    /**
     * @return mixed
     */

    public function getDb() :Db
    {
        return $this->_db;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db): void
    {
        $this->_db = $db;
    }

    /**
     * @return mixed
     */
    public function getDespetcher():Despetcher
    {
        return $this->_despetcher;
    }

    /**
     * @param mixed $despetcher
     */
    public function setDespetcher($despetcher): void
    {
        $this->_despetcher = $despetcher;
    }

    /**
     * @return mixed
     */
    public function getRequest():Request
    {
        return $this->_request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request): void
    {
        $this->_request = $request;
    }


}