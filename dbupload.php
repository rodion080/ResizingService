<?php
require_once "models/DBImageModel.php";
require_once "libs/DB.php";
use models\DBImageModel;
use libs\DB;

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
    $db->row('CREATE TABLE resized_images ( img_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, img_status VARCHAR(30), img_name VARCHAR(255))');
}

//получение данных со стороны клиента
$name=substr(strval(time()), 6,3).$_POST['img_name'];
$status=$_POST['img_status'];

//занесенение нового изображения в таблицу
$imageDB = new DBImageModel();
$imageDB->setName($name);
$imageDB->setStatus($status);
$imageDB->save();

//выгружаем новое имя и id
echo json_encode(
    [
        'id'=>$imageDB->getId(),
        'name'=>$name
    ]);