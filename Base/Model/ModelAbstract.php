<?php


namespace Base\Model;


abstract class ModelAbstract
{
    /**
     * @return mixed
     */
    abstract function getTable();

    /**
     * @param array $data
     * @return mixed
     */
    abstract function initByDBData(array $data);
}