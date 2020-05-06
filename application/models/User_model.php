<?php
class User_model extends CI_model{
    public function __construct(){
        $this->load->database();
       }

       public function register($mobile){
        $obj = new stdClass();
        if(trim($mobile, " ")){
        // if($this->user_model->checkUserEmail($email)->value){
          if($this->user_model->checkUser($mobile)->value){
         $query = $this->db->query("insert into user (`phone`)values('$mobile')");
         if($query){
        $id=$this->db->insert_id();
        $this->user_model->createOTP($id);
        $obj->value = true;
        $obj->message = "User registered successfully!";
        return $obj ;
        }else{
        $obj->value = false;
        $obj->message ="Something went wrong, please try again later." ;
        return $obj ;
        }
        }else{
         return $this->user_model->checkUser($mobile);
        }
        // }else{
        // return $this->user_model->checkUserEmail($email);
        // }
        }else{
        $obj->value = false;
        $obj->message ="Mobile number is required" ;
        return $obj ;
        }
        }
    
    
        public function checkUser($mobile){
        $query = $this->db->query("select * from user where phone='$mobile'");
        $obj = new stdClass();
        if($query->num_rows() > 0){
          $obj->value = false;
          $obj->field = "phone";
          $obj->message ="Mobile number already exists. Please use a different Mobile number." ;
          return $obj ;
        }else{
          $obj->value = true;
          return $obj ;
         }
        }
    
        public function genRandStr(){
        $characters = '1234567890';
            $length = 6;
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    
      public function createOTP($id){
        $obj = new stdClass();
        $this->load->helper('string');
        $passwrod=$this->user_model->genRandStr();
        // $passwrod=random_string('alnum',6);
        $query = $this->db->query("update user set password='$passwrod' where id=$id");
        if($query){
          $data = $this->db->query("select * from user where id=$id")->row();
          $sendData['data'] = $data;
        //   $viewcontent = $this->load->view('emailers/registeruser', $sendData, true);
        //   $this->sms_model->send_SMS('8082495670',$data->phone,'AStore: Your verification code is -'.$passwrod);
          $obj->value = true;
          $obj->message = "User registered successfully!";
          return $obj ;
        }else{
          $obj->value = false;
          $obj->message = "Error while generating password, please try again later.";
          return $obj ;
        }
        }

}
?>