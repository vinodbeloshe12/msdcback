<?php
  class Product_model extends CI_Model {

    public function __construct(){
       $this->load->database();
      }



      public function getAllProducts($lang){
        if($lang=="en"){
          $query = $this->db->query("SELECT `id`, `name_english` as 'name', `description_hindi` as 'description', `image`, `price`, `price_per`, `discount_price`, `unit_english` as 'unit',`discount`, `quantity`, `status`, `category` FROM `product` WHERE 1 AND status=1");
        }else{
          $query = $this->db->query("SELECT `id`, `name_marathi`as 'name', `description_marathi` as 'description', `image`, `price`, `price_per`, `discount_price`, `unit_marathi` as 'unit',`discount`, `quantity`, `status`, `category` FROM `product` WHERE 1 AND status=1");
        }
        $obj = new stdClass();
        if (!$query){
          $obj->value = false;
         $obj->message ="Data not found" ;
          return $obj ;
           }else{
          $obj->value = true;
          $obj->data = $query->result_array();
          return $obj ;
        }
      }



      public function getPackageDetails($name){
        $data = $this->db->query("SELECT `id` FROM `package` WHERE flag=1 and web_title='$name' ")->row();
        $packge_id = $data->id;
        $query= $this->db->query("SELECT p.`id`, p.`title`, p.`web_title`,p.`meta_title`,p.`meta_description`,p.`meta_keywords`, p.`subtitle`, t.`name` as 'type', p.`name`, p.`location`, p.`price`, p.`duration`, p.`description`, p.`banner_image`, p.`sortOrder`, p.`lat`, p.`lang`, p.`activities`, p.`inclusions`, p.`thingstocarry`, p.`flag`, p.`regdate`, p.`user` FROM `package` p LEFT JOIN type t ON p.type=t.id WHERE p.flag=1 and p.id=$packge_id ORDER BY p.sortOrder");
         $images=$this->db->query("SELECT * FROM `package_images` WHERE package_id=$packge_id");
        if($images->num_rows() == 0){
           $gallery=$this->db->query("SELECT * FROM `gallery`")->result_array();
          }else{
            $gallery=[];
          }
        $obj = new stdClass();
        if($query->num_rows() > 0){
           $obj->value = true;
           $obj->details = $query->row();
           $obj->images = $images->result_array();
           $obj->gallery = $gallery;
           return $obj ;
       
         }else{
          $obj->value = false;
        $obj->data = [];
        $obj->message ="Records not found on your specific input" ;
        return $obj ;
         }
       }


  


public function deleteContent($id){
  $query= $this->db->query("delete from content where id=$id");
  $obj = new stdClass();
   if ($this->db->affected_rows() != 1){
     $obj->value = false;
    $obj->message ="Deletion failed" ;
     return $obj ;
 
   }else{
     $obj->value = true;
     $obj->message =" Records deleted,1 row affected" ;
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