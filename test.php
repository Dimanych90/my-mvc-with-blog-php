<?php
require "Base/init.php";

use Base\Model\Factory as Factory;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();


$app = new \Base\Aplication();

$app->ini();

try {
    $user = Factory::getById(Factory::MODEL_USER, __FILE__, 7);

} catch (Exception $e) {
}
$db = \Base\Context::getInstance()->getDb();
echo $db->getLog();
var_dump($db->getFetch());

function cube($n)
{
    return ($n * $n * $n);
}

$a = [1, 2, 3, 4, 5];
$b = array_map('cube', $a);
print_r($b);













