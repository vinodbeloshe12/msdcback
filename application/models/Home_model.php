<?php
class Home_model extends CI_model{
    public function __construct(){
        $this->load->database();
       }

       public function getNavigation(){
        $query= $this->db->query("select * from `navigation` where flag=1 and parentNavId=0 order by sortOrder");
        $obj = new stdClass();
        if($query->num_rows()==0){
          $obj->value = false;
          $obj->message ="Records not found" ;
          return $obj ;
        }else{
          $obj->value = true;
          $rawdata = $query->result_array();
          // prepare the data into a multidimensional array
            $data = array();
            foreach($rawdata as $row)
            {
            $subnav = $this->db->query("select * from `navigation` where flag=1 and parentNavId=".$row['id']." order by sortOrder");
            $row['subnav'] = $subnav->result_array();
            array_push($data, $row);
            }
           $obj->data = $data;
         return $obj ;
        }
      }

      public function getHome(){
        $packages= $this->db->query("SELECT `id`, `title`, `web_title`, `name`, `location`, `price`, `duration`, `image` FROM `package` WHERE flag=1 AND type=1 ORDER BY sortOrder LIMIT 0,6");
        $activities= $this->db->query("SELECT `id`, `name`, `banner_image`,`price`, `image` FROM `activity` WHERE flag=1 ORDER BY sortOrder limit 5");
        $obj = new stdClass();
        if(!$packages){
          $obj->value = false;
          $obj->message ="Records not found" ;
          return $obj ;
        }else{
          $obj->value = true;
          $obj->packages = $packages->result_array();
          $obj->activities = $activities->result_array();
         return $obj ;
        }
       }


       public function getContent($name){
        $query= $this->db->query("select * from `content` where name='$name'");
        $obj = new stdClass();
        if(!$query){
          $obj->value = false;
          $obj->message ="Records not found" ;
          return $obj ;
        }else{
          $obj->value = true;
          $obj->data = $query->row();
         return $obj ;
        }
       }


       public function getContact(){
        $query= $this->db->query("select * from `contact` order by id desc");
        $obj = new stdClass();
        if(!$query){
          $obj->value = false;
          $obj->message ="Records not found" ;
          return $obj ;
        }else{
          $obj->value = true;
          $obj->data = $query->result_array();
         return $obj ;
        }
       }

       public function deleteContact($id){
        $query= $this->db->query("delete from contact where id=$id");
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
}
?>