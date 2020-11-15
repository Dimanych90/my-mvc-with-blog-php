<?php


namespace Base;


use Throwable;

class RedirectException extends \Exception
{
    private $_location;

   public function __construct($message = "", $code = 0, Throwable $previous = null)
   {
       parent::__construct($message, $code, $previous);
       $this->_location = $message;
   }


    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->_location;
    }
}