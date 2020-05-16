<?php
require_once "models/DBImageModel.php";
require_once 'deb.php';
use models\DBImageModel;

//получение данных из адресной строки
$id = $_GET['id'];

//получение данных из базы данных
$dbModel = new DBImageModel();
$dbModel->find($id);
$imgName = $dbModel->getName();
$status =$dbModel->getStatus();

$link = $_SERVER['HTTP_HOST'].'/img/'.$imgName;

$response = [
    'id'=>$id,
    'status'=>$status,
    'name'=>$imgName,
    'link'=>$link
];

echo json_encode($response);