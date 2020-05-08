<?php
//получение данных из адресной строки
$id = $_GET['id'];
$imgName = $_GET['imgname'];
$status = $_GET['status'];

//отображение id
echo "id".$id.":completed";
echo "<br>";

//вывод статуса
echo "status:".$status;
echo "<br>";

//ссылка на скачку файла
echo "<a download='9845eFRJ3RomlM2' href='img/".$_GET['imgname']."'>download</a>";