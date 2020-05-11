<?php
require_once "models/DBImageModel.php";
use models\DBImageModel;

//получение данных из адресной строки
$id = $_GET['id'];

//получение данных из базы данных
$dbModel = new DBImageModel();
$dbModel->find($id);
$imgName = $dbModel->getName();
$status =$dbModel->getStatus();

$result = [
    'id'=>$id,
    'status'=>$status,
    'name'=>$imgName
];

echo json_encode($result);
if($dbModel->getStatus()=="complete") {
    echo "<br><a download='" . $imgName . "' href='img/" . $imgName . "'>download</a>";
}