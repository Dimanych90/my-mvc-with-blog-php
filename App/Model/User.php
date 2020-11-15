<?php


namespace App\Model;


use Base\Context;
use Base\Db;
use Base\Model\ModelAbstract;
use Base\Session;
use Base\Controller;

class User extends ModelAbstract
{

    protected $_id;
    protected $_login;
    protected $_password;
    protected $_email;

    public function getTable()
    {
        return 'newusers';
    }

    public function initByDBData(array $data)
    {
        $this->_id = $data ['id'] ?? '';
        $this->_login = $data['login'] ?? '';
        $this->_password = $data['password'] ?? '';
        $this->_email = $data['email'] ?? '';
    }


    public function __construct()
    {

    }

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
    public function getLogin()
    {
        return $this->_login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->_login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->_password = sha1($password);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->_email = $email;
    }


    public function users()
    {
        $this->_id = $_POST['id'] ?? '';
        $this->_login = $_POST['login'] ?? '';
        $this->_password = sha1($_POST['password']) ?? '';
        $this->_email = $_POST['email'] ?? '';

    }



    public function insert()
    {
        $ins = Db::instance();
//        $this->users();
        $table =  $this->getTable();
        $ins->exec("INSERT INTO $table (login, email, password) VALUES
(:login,:email,:password)", __METHOD__, [':login' => $this->_login, ':email' => $this->_email, ':password' => $this->_password]);
    }

    public function initByData($data)
    {
        $this->_login = $data['login'] ?? '';
        $this->_password = sha1($data['password']) ?? '';
        $this->_email = $data['email'] ?? '';
    }

    public function userauthorize()
    {
        $query = Context::getInstance()->getDb();
        $table = $this->getTable();

//  do not forget      $this->users();
        $data =  $query->fetchOne(("SELECT * FROM $table WHERE `login` = :login AND
`password` = :password AND `email` = :email"), __METHOD__, [':login' => $this->_login, ':password' => $this->_password,
            ':email' => $this->_email]);


//       print_r($query->getFetch()[0]['id']);

        if ($data) {
//            var_dump($data);
            $session = Session::instance();
            $session->save($data[0]['id']);
//            var_dump($data[0]['id']);die();

            return true;

        }
        return false;
    }

    public function fetchOne()
    {
        $query = Db::instance();
        $table = $this->getTable();
        $this->users();
        $query->fetchOne(("SELECT * FROM $table WHERE `login` = :login AND
`password` = :password AND `email` = :email"), __METHOD__, [':login' => $this->_login, ':password' => $this->_password,
            ':email' => $this->_email]);
    }


}