<?php
require_once "classes/DBImageModel.php";
use classes\DBImageModel;

//получение данных из адресной строки
$id = $_GET['id'];

//получение данных из базы данных
$dbModel = new DBImageModel();
$dbModel->find($id);
$imgName = $dbModel->getName();
$status = $dbModel->getStatus();

//отображение id
$complOrFailed = ($status!=404)?"completed":"failed";
echo 'id'.$id.':'.$complOrFailed;
echo "<br>";

//вывод статуса
echo "status:".$status;
echo "<br>";

//ссылка на скачку файла
if($status==200) {
    echo "<a download='" . $imgName . "' href='img/" . $imgName . "'>download</a>";
}