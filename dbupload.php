<?php
require_once "classes/DBImageModel.php";
require_once "classes/DB.php";
use classes\DBImageModel;
use classes\DB;

//проверяем есть ли таблица для данных в базе данных
//если нет, то создаем ее.
$db = new DB();
$configs= require"configs/db.php";
$tableExists=false;
foreach ($db->row("SHOW TABLES") as $table){
    if($table['Tables_in_'.$configs['dbname']] == 'resized_images'){
        $tableExists=true;
    }
}
if(!$tableExists){
    $db->row('CREATE TABLE resized_images ( img_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, img_status INT(11), img_name VARCHAR(255))');
}

//получение данных со стороны клиента
$name=$_POST['img_name'];
$status=$_POST['img_status'];

//занесенение нового изображения в таблицу
$imageDB = new DBImageModel();
$imageDB->setName($name);
$imageDB->setStatus($status);
$imageDB->save();





echo json_encode(['id'=>$imageDB->getId()]);