<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];
header("Access-Control-Allow-Origin:  $http_origin");
// header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
require(APPPATH.'/libraries/REST_Controller.php');
require APPPATH . 'libraries/Format.php';
 // use namespace
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller{
    // var $serverIp = 'https://shreeyantraindia.com/shreeyantrabackend/';
    var $serverIp = 'http://192.168.22.154/shreeyantra/';
  
    public function __construct()
    {
        parent::__construct();
        // $imageServer = 'https://shreeyantraindia.com/shreeyantrabackend/uploads/';
        $imageServer = '';
        // $imageServer = 'http://192.168.22.154/shreeyantrabackend/uploads/';
        $this->config->set_item('imageServer', $imageServer);
        // $this->load->model('category_model');
        $this->load->library('session');
    }


  //register user
  public function registerUser_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    // print_r($params);
     $mobile= $params['mobileno'];
     $result = $this->user_model->register($mobile);
     $this->response($result, 200);      
}

//check OTP
function checkOTP_post(){
  $params = json_decode(file_get_contents('php://input'), TRUE);
    // print_r($params);
     $mobile= $params['mobileno'];
     $password= $params['password'];
  $result = $this->user_model->checkOTP($mobile,$password);
  $this->response($result, 200); 

}


// get all product list
function getAllProducts_get(){
  $lang='ma';
  $result = $this->product_model->getAllProducts($lang);
  $this->response($result, 200); 
}
  
//add to cart 
public function addToCart_post(){
  $params = json_decode(file_get_contents('php://input'), TRUE);
  $data = array(
      'product_id'=>$params['product_id'],
      'quantity'=>$params['quantity'] ,      
      'user_id'=>$params['user_id'] 
  );
       $result = $this->cart_model->addToCart($data);
      $this->response($result, 200); 
 }

 //get cart
public function getCart_post(){
  $params = json_decode(file_get_contents('php://input'), TRUE);
  $lang=$params['language'];
  $user=$params['user_id'];
  $result = $this->cart_model->getCart($lang,$user);
  $this->response($result, 200); 
 }

  //delete cart
public function deleteCart_post(){
  $params = json_decode(file_get_contents('php://input'), TRUE);
  $id=$params['id'];
  $user=$params['user_id'];
  $result = $this->cart_model->deleteCart($id,$user);
  $this->response($result, 200); 
 }

}
