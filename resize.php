<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return;}
require_once "models/SimpleImage.php";
require_once "models/DBImageModel.php";
use models\SimpleImage;
use models\DBImageModel;

//создаем параметры нового изображения
$id=$_POST['imgId'];
$newWidth=intval($_POST['imgWidth']);
$newHeigth=intval($_POST['imgHeight']);
$imageFile=$_FILES['imgToProcess'];
$name=$imageFile['name'];
$directory = "img";

//создание новой директории по необходимости
if(!is_dir($directory)){
    mkdir($directory);
}

//перемещение файла в директорию
move_uploaded_file($imageFile['tmp_name'], $directory.'/'.$name);

//используем класс "SimpleImage" для управления изображением
try {
    $image = new SimpleImage();
    $image->find($directory . '/' . $name);
    $image->resize($newWidth, $newHeigth);
    $image->save($directory . '/' . $name);

    $dbImage = new DBImageModel();
    $dbImage->find($id);
    $dbImage->setStatus('complete');
    $dbImage->save();
}catch (Exception $exc){
    $dbImage = new DBImageModel();
    $dbImage->find($id);
    $dbImage->setStatus('error:'.$exc->getMessage());
    $dbImage->save();
    unlink($directory.'/'.$name);
}