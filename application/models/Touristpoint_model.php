<?php
  class Touristpoint_model extends CI_Model {

    public function __construct(){
       $this->load->database();
      }



      public function getAllTouristPoints(){
        $query = $this->db->query("SELECT * FROM `tourist_point`");
        $obj = new stdClass();
        if($query->num_rows() > 0){
          $obj->value = true;
          $obj->data = $query->result_array();
          return $obj ;
          }else{
            $obj->value = false;
            $obj->message ="Data not found" ;
             return $obj ;
        }
      }

      public function getTouristPoint($id){
        $query = $this->db->query("SELECT * FROM `tourist_point` WHERE `id`=$id");
        $images = $this->db->query("SELECT * FROM `touristpoint_image` WHERE `touristpoint_id`=$id");
        $obj = new stdClass();
        if($query->num_rows() > 0){
          $obj->value = true;
          $obj->images = $images->result_array();
          $obj->data = $query->row();
          return $obj ;
          }else{
            $obj->value = false;
            $obj->images = [];
            $obj->message ="Data not found" ;
             return $obj ;
        }
      }




      public function createTouristPoint($data){
        $insertData=array("title" => $data['title'],"web_title" =>  $data['web_title'],"meta_title" =>  $data['meta_title'],"meta_keywords" =>  $data['meta_keywords'],"meta_description" =>  $data['meta_description'],"description" =>  $data['description'],"banner_image" =>  $data['banner_image'],"image" =>  $data['image'],"status" =>  $data['status'],"user" =>  $data['user']);
        $this->db->insert('tourist_point',$insertData);
        $obj = new stdClass();
        if ($this->db->affected_rows() != 1){
          $obj->value = false;
         $obj->message ="Insertion failed" ;
          return $obj ;
      
        }else{
          $touristPointId =$this->db->insert_id();
          if($data['images']){
            $this->touristpoint_model->insertTouristPointImages($data['images'],$touristPointId);
          }
          $obj->value = true;
          $obj->message ="Record inserted" ;
          return $obj ;
        }
      }

      public function insertTouristPointImages($data,$touristPointId){
        $obj = new stdClass();
        $user=$this->session->userData->data['id'];
       $DataArr = array();
       foreach ($data as $key => $value){
           array_push($DataArr,array("image" => $value['image_name'],"user" =>$user,"touristpoint_id" => $touristPointId));
       }
       $this->db->insert_batch('touristpoint_image',$DataArr);
       if ($this->db->affected_rows() != 1){
         $obj->value = false;
        $obj->message ="Insertion failed" ;
         return $obj ;
       }else{
         $obj->value = true;
         $obj->message ="Record inserted" ;
         return $obj ;
       }
     }

    

public function updateContentPage($data, $id){
 $this->db->where('id', $id);  
 $this->db->update('content', $data);  
 $obj = new stdClass();
if ($this->db->affected_rows() != 1){
 $obj->value = false;
$obj->message ="Updation failed" ;
 return $obj ;

}else{
 $obj->value = true;
 $obj->message ="Content page updated successfully!" ;
 return $obj ;
}
}


public function deleteTouristPoint($id){
  $query= $this->db->query("delete from tourist_point where id=$id");
  $obj = new stdClass();
   if ($this->db->affected_rows() != 1){
     $obj->value = false;
    $obj->message ="Deletion failed" ;
     return $obj ;
 
   }else{
    $this->db->query("delete from touristpoint_image where touristpoint_id=$id");
     $obj->value = true;
     $obj->message =" Records deleted" ;
     return $obj ;
   }
 }

 public function search($term){
   $query=$this->db->query("select * from product where name_english like '%$term%'");
   $obj = new stdClass();
   if (!$query){
     $obj->value = false;
    $obj->message ="Records not found" ;
     return $obj ;
 
   }else{
     $obj->value = true;
     $obj->data = $query->result_array();
     return $obj ;
   }
 }

}


?>