<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];
header("Access-Control-Allow-Origin:  $http_origin");

//  header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
require(APPPATH.'/libraries/REST_Controller.php');
require APPPATH . 'libraries/Format.php';
 // use namespace
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller{
    var $serverIp = 'http://localhost/msdc_backend/';
  
    public function __construct()
    {
        parent::__construct();
        $imageServer = 'http://localhost/msdc_backend/uploads/';
        $this->config->set_item('imageServer', $imageServer);
         // $this->load->library('session');
    }


    //register user
    public function registerUser_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
        $name= $params['name'];
        $email=$params['email'];     
        $username=$params['username'];       
        $result = $this->user_model->register($name,$email,$username);
        $this->response($result, 200);      
   }


      //contact submit
      public function submitContact_post(){
        $params = json_decode(file_get_contents('php://input'), TRUE);
            $name= $params['name'];
            $email=$params['email'];     
            $phone=$params['phone'];       
            $subject=$params['subject'];       
            $message=$params['message'];       
            $result = $this->user_model->submitContact($name,$email,$phone,$subject,$message);
            $this->response($result, 200);      
       }


     

    //user login
    function login_post(){
        $params = json_decode(file_get_contents('php://input'), TRUE);
        $username = $params['username'];
        $password = $params['password'];
        $result = $this->user_model->login($username,$password);
        if($result->value){
            $this->session->set_userdata('userData', $result);
        }
        $this->response($result, 200);  
    }

    // change password
    public function changePassword_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $oldpass = $params['oldpass'];
    $newpass = $params['newpass'];
     $result = $this->user_model->changePassword($oldpass,$newpass);
    $this->response($result, 200); 
    }

    function getUserDetails_get(){
        $obj = new stdClass();
        if($this->session->userData){
        //  $result = $this->session->userData;
        $id=$this->session->userData->data['id'];   
        $result = $this->user_model->getUserDetails($id);
         $this->response($result, 200); 
        }else{
        $obj->value=false;
        $obj->message="User Not Logged in";
        $this->response($obj, 200); 
        }
    }

    function logout_get(){
        $this->session->sess_destroy();
        $obj->value = true;
        $obj->data = [];
        $obj->message = "User logged out successfully!" ;
        $this->response($obj, 200);  
    }


    function getContent_get(){
        $name=  $this->get('name');
        $result = $this->home_model->getContent($name);
        $this->response($result, 200);  
    }


#------------------------------ Navigation Start ----------------------------# 
function getNavigation_get(){
    $result = $this->home_model->getNavigation();
    $this->response(json_decode(json_encode($result, JSON_NUMERIC_CHECK)), 200); 
}
function getHome_get(){
    $result = $this->home_model->getHome();
    $this->response($result, 200);  
}
 #------------------------------ Navigation End -----------------------------------#


#------------------------------ Contact Start ----------------------------# 
function getContact_get(){
    $result = $this->home_model->getContact();
    $this->response(json_decode(json_encode($result, JSON_NUMERIC_CHECK)), 200); 
}

function deleteContact_get(){
    $id=  $this->get('id');
    $result = $this->home_model->deleteContact($id);
    $this->response($result, 200);  
  }
 #------------------------------ Contact End -----------------------------------#


 
#------------------------------ Package Start ----------------------------# 
function getAllPackages_get(){
    $result = $this->package_model->getAllPackages();
    $this->response($result, 200); 
}

function getPackageDetails_get(){
    $name=  $this->get('name');
    $result = $this->package_model->getPackageDetails($name);
    $this->response($result, 200);  
  }
 #------------------------------ Package End -----------------------------------#

}