<?php
require_once "image_class/SimpleImage.php";
use image_class\SimpleImage;

session_start();
if(!isset($_SESSION['id'])) {
    $_SESSION['id']=0;
}else{
    $_SESSION['id']++;
}
//создаем параметры нового изображения
$id=$_SESSION['id'];
$newWidth=intval($_POST['imgWidth']);
$newHeigth=intval($_POST['imgHeight']);
$imageFile=$_FILES['imgToProcess'];
$newImgName=substr(strval(time()), 6,3).$imageFile['name'];
$directory = "img";

//создание новой директории по необходимости
if(!is_dir($directory)){
    mkdir($directory);
}
//перемещение файла в директорию
move_uploaded_file($imageFile['tmp_name'], $directory.'/'.$newImgName);

//используем класс "SimpleImage" для управления изображением
$image = new SimpleImage();
$image->find($directory.'/'.$newImgName);
$image->resize($newWidth, $newHeigth);
$image->save($directory.'/'.$newImgName);

//вывод данных на сторону клиента
$result=[
    'id'=>$id,
    'new_img_name'=>$newImgName
];
echo json_encode($result);