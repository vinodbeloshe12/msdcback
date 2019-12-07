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
        $packages= $this->db->query("SELECT `id`, `title`, `web_title`, `name`, `location`, `price`, `duration`, `image` FROM `package` WHERE flag=1 AND type=1 ORDER BY sortOrder LIMIT 0,20");
        $activities= $this->db->query("SELECT `id`, `name`, `banner_image`,`price`, `image` FROM `activity` WHERE flag=1 ORDER BY sortOrder limit 5");
        $tourist_points= $this->db->query("SELECT `id`, `title`, `web_title`,`meta_description`,`image` FROM `tourist_point` WHERE status=1 limit 4");
        $obj = new stdClass();
        if(!$packages){
          $obj->value = false;
          $obj->message ="Records not found" ;
          return $obj ;
        }else{
          $obj->value = true;
          $obj->packages = $packages->result_array();
          $obj->activities = $activities->result_array();
          $obj->tourist_points = $tourist_points->result_array();
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

       public function bookNow($data){
        $insertData=array("name" => $data['name'],"package_name" => $data['package_name'],"phone" =>  $data['phone'],"email" =>  $data['email'],"city" =>  $data['city'],"arrival_date" =>  $data['arrival_date'],"deputure_date" =>  $data['deputure_date'],"adults" =>  $data['adults'],"childrens" =>  $data['childrens'],"min_price" =>  $data['min_price'],"max_price" =>  $data['max_price']);
        $this->db->insert('enquiry',$insertData);
        $sendData['data'] = $insertData;
        $obj = new stdClass();
        if ($this->db->affected_rows() != 1){
          $obj->value = false;
         $obj->message ="Insertion failed" ;
          return $obj ;
      
        }else{
          $viewcontent = $this->load->view('emailers/enquiry', $sendData, true);
          $this->email_model->emailer($viewcontent,'New Enquiry - Malvan Tarkarli Tour Planner ','vinodbeloshe12@gmail.com',"Vinod");
          $obj->value = true;
          $obj->message ="Record inserted" ;
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