<?php
require_once "classes/DBImageModel.php";
use classes\DBImageModel;

//получение данных со стороны клиента
$name=$_POST['img_name'];
$status=$_POST['img_status'];

//занесенение нового изображения в таблицу
$imageDB = new DBImageModel();
$imageDB->setName($name);
$imageDB->setStatus($status);
$imageDB->save();

echo json_encode(['id'=>$imageDB->getId()]);