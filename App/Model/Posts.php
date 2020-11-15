<?php


namespace App\Model;


use Base\Context;
use Base\Db;
use Base\Model\ModelAbstract;

class Posts extends ModelAbstract
{
    private $_id;
    private $_userId;
    private $_message;
    private $_dateTime;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->_userId;

    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->_userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->_message = $message;
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->_dateTime;
    }

    /**
     * @param mixed $dateTime
     */
    public function setDateTime($dateTime): void
    {
        $this->_dateTime = $dateTime;
    }

    public function getTable()
    {
        return 'posts';
    }

    public function initByDBData(array $data)
    {
        $this->_id = $data ['id'] ?? '';
        $this->_userId = $data['user_id'] ?? '';
        $this->_message = $data['message'] ?? '';
        $this->_dateTime = $data['datetime'] ?? '';
    }

    public function initByData($data)
    {
        $this->_userId = $data['user_id'] ?? '';

        $this->_message = $data['message'] ?? '';
    }

    public function insert()
    {
        $ins = Context::getInstance()->getDb();
        $table = $this->getTable();
        $this->_dateTime = date("Y-m-d H:i:s");
        $data = $ins->exec("INSERT INTO $table (user_id, message, datetime) VALUES
(:user_id,:message,:datetime)", __METHOD__, [':user_id' => $this->_userId, ':message' => $this->_message, ':datetime' => $this->_dateTime]);

//        var_dump($data);die();
        return $data;
    }

}