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

  

}
