<?php


namespace Base\Model;


//use App\Model\User;
use Base\Context;


class Factory
{
    const MODEL_USER = 1;
    const MODEL_POSTS = 2;

    public static function getModelStorage()
    {
        return [
            self::MODEL_USER => [
                'class_name' => 'App\\Model\\User'
            ], self::MODEL_POSTS => ['class_name' => 'App\\Model\\Posts']
        ];
    }

    /**
     * @param int $modelClassName \Base\Model\Factory::Model*
     * @param int $id
     * @return ModelAbstract
     */
    public static function getById(int $modelTypeId, $_method, int $id)
    {

        $db = Context::getInstance()->getDb();

        $config = self::getModelStorage();
        if (!$config) {
            throw new \Exception('no type id of model in' . $modelTypeId);
        }
        $modelconfig = $config[$modelTypeId];
        $modelClassName = $modelconfig['class_name'];

        /** @var ModelAbstract $model */

        $model = new $modelClassName();

        $table = $model->getTable();

        $query = "SELECT * FROM $table WHERE id = :id";
//        $data = [];
        $data = $db->fetchOne($query, $_method, [':id' => $id]);


//        var_dump($db->getFetch());
//var_dump($data[0][0]);die();
        if (!$data) {
            return null;
        }
        $model->initByDBData($data[0]);
//        var_dump($model);
//        var_dump($data);
        return $model;
    }

    public static function getByIds($modelTypeId, $_method, array $ids)
    {

        $db = Context::getInstance()->getDb();

        $return = [];
        $config = self::getModelStorage();
        $modelconfig = $config[$modelTypeId];
        $modelClassName = $modelconfig['class_name'];
        array_walk($ids, function (&$id) {
            $id = (int)$id;
        });
        $ids = array_unique($ids);
        $idsStr = implode(',', $ids);
        $model = new $modelClassName();
        $table = $model->getTable();
        $select = "SELECT * FROM $table WHERE id IN($idsStr)";
        $data = [];
        $data = $db->fetchAll($select, $_method, []);

        if ($data) {
            foreach ($data as $elem) {
                /** @var ModelAbstract $model */
                $model = new $modelClassName();
                $model->initByDbData($elem);
                $return[$elem['id']] = $model;

            }
        }

        return $return;
    }

    /**
     * @param $modelTypeId
     * @param $_method
     * @param int $limit
     * @param array $filter
     * @param string $order
     * @return ModelAbstract[]
     * @throws \Exception
     */


    public static function getList($modelTypeId, $_method, int $limit, array $filter = [], string $order = '')
    {
        $db = Context::getInstance()->getDb();

        $return = [];
        $config = self::getModelStorage();
        $modelconfig = $config[$modelTypeId];
        $modelClassName = $modelconfig['class_name'];

        /** @var ModelAbstract $model */
        $model = new $modelClassName();
        $table = $model->getTable();

        $filterStr = '';
        if ($filter) {
            $filterStr = 'WHERE';
            // todo implement
        }

        $orderStr = '';
        if ($order) {
            $orderStr = "ORDER BY $order";
        }

        $select = "SELECT * FROM $table {$filterStr} {$orderStr} LIMIT  $limit";
        $data = [];
       $data = $db->fetchAll($select, $_method,[]);

        if ($data) {
//            $data = [];
            foreach ($data as $elem) {
                $model = new $modelClassName();
                $model->initByDbData($elem);
                $elem['user_id'] = $model;
                $return[] = $model ;
            }
        }

        return $return;
    }
}