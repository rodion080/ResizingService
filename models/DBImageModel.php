<?php
namespace models;
require_once "libs/DB.php";
use libs\DB;

class DBImageModel {

    private $id;
    private $name;
    private $status;
    private $db;

    public function __construct($id=NULL, $name=NULL, $status=NULL){
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->db=new DB();
    }

    public function find($id){
        $data = $this->db->row('SELECT * FROM resized_images WHERE img_id=:img_id', ['img_id'=>$id]);
        if(!$data){
            die("The image with such id was not found!");
        }
        $this->id=$data[0]['img_id'];
        $this->name=$data[0]['img_name'];
        $this->status=$data[0]['img_status'];
    }

    //если экземпляр класса создан без id, значит создаем новую таблицу
    //если id присутствует - обновляем запись в таблице
    public function save(){
        if($this->id==NULL) {
            $query="INSERT INTO resized_images (img_status, img_name) VALUES (:img_status, :img_name)";
            $params = ['img_status' => $this->status,'img_name' => $this->name];
            $this->db->row($query,$params);

            $this->id=intval($this->db->row("SELECT img_id FROM resized_images WHERE img_name=:img_name", [
                'img_name'=>$this->getName()
            ])[0]['img_id']);
        }else{
            $query="UPDATE resized_images SET img_status=:img_status, img_name=:img_name  WHERE img_id=:img_id";
            $params = ['img_id'=>$this->getId(),'img_status'=>$this->getStatus(), 'img_name'=>$this->getName()];
            $this->db->row($query, $params);
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }



}