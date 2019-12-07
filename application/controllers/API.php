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

 
#------------------------------ Touristpoint Start ----------------------------# 
// get all tourist points list
function getAllTouristPoints_get(){
    $result = $this->touristpoint_model->getAllTouristPoints();
    $this->response($result, 200); 
}


// create tourist point
function createTouristPoint_post(){
    
    // if (!is_dir('uploads11/')) {
    //     mkdir('./uploads11/', 0777, TRUE);
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'gif|jpg|png';
    $this->load->library('upload', $config);
    $filename = 'image';
    $image = '';  
     //get input as form-data
    if ($this->upload->do_upload($filename)) {
        $uploaddata = $this->upload->data();
        $image =$uploaddata['file_name'];
     }

     $bannerfilename = 'banner_image';
     $banner_image = '';  
      //get input as form-data
     if ($this->upload->do_upload($bannerfilename)) {
         $uploaddata1 = $this->upload->data();
         $banner_image =$uploaddata1['file_name'];
      }

    //   upload image gallery
    $image_name = array();
    $ImageCount = count($_FILES['image_name']['name']);
              for($i = 0; $i < $ImageCount; $i++){
              $_FILES['file']['name']       = $_FILES['image_name']['name'][$i];
              $_FILES['file']['type']       = $_FILES['image_name']['type'][$i];
              $_FILES['file']['tmp_name']   = $_FILES['image_name']['tmp_name'][$i];
              $_FILES['file']['error']      = $_FILES['image_name']['error'][$i];
              $_FILES['file']['size']       = $_FILES['image_name']['size'][$i];
              // File upload configuration
             $config['upload_path'] = './uploads/';
              $config['allowed_types'] = 'jpg|jpeg|png|gif';
              // Load and initialize upload library
              $this->load->library('upload', $config);
              $this->upload->initialize($config);
              // Upload file to server
              if($this->upload->do_upload('file')){
                  // Uploaded file data
                  $imageData = $this->upload->data();
                   $uploadImgData[$i]['image_name'] =$imageData['file_name'];
                }
         }
// }
      $data = array(
      'title'=>$this->input->get_post('title'),
      'web_title'=>$this->input->get_post('web_title'),
      'description'=>$this->input->get_post('description'),
      'meta_title'=>$this->input->get_post('meta_title'),
      'meta_keywords'=>$this->input->get_post('meta_keywords'),
      'meta_description'=>$this->input->get_post('meta_description'),
      'banner_image'=>$banner_image,
      'image'=>$image,
      'status'=>$this->input->get_post('status'),
      'user'=>$this->session->userData->data['id'],
      'images'=>$uploadImgData   
  );
  $id =$this->input->get_post('id');
  $obj = new stdClass();
  if($this->session->userData){
       if($this->session->userData->data['accesslevel']=='1'){
           if($id){
               $result = $this->category_model->upateTouristPoint($data,$id);
           }else{
               $result = $this->touristpoint_model->createTouristPoint($data);
           }
        $this->response($result, 200); 
      }else{
        $obj->value = false;
        $obj->message ="Operation not Permitted. You dont have rights to this call" ;
        $this->response($obj, 200); 
      }
    
  }else{
    $obj->value = false;
    $obj->message ="Please Login to continue" ;
    $this->response($obj, 200); 
  }
  
}

function gettouristpointDetails_get(){
    $name=  $this->get('name');
    $result = $this->touristpoint_model->gettouristpointDetails($name);
    $this->response($result, 200);  
  }

function deleteTouristPoint_get(){
    $id=  $this->get('id');
    $result = $this->touristpoint_model->deleteTouristPoint($id);
    $this->response($result, 200);  
  }

  function getTouristPoint_get(){
    $id=  $this->get('id');
    $result = $this->touristpoint_model->getTouristPoint($id);
    $this->response($result, 200);  
  }


 #------------------------------ Touristpoint End -----------------------------------#

 
#------------------------------ Package Start ----------------------------# 
function getAllPackages_get(){
    $result = $this->package_model->getAllPackages();
    $this->response($result, 200); 
}

function bookNow_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $data = array(
        'name'=>$params['name'],
        'package_name'=>$params['package_name'],
        'phone'=>$params['phone'],
        'email'=>$params['email'],
        'city'=>$params['city'],
        'arrival_date'=>$params['arrival_date'],
        'deputure_date'=>$params['deputure_date'],
        'adults'=>$params['adults'],
        'childrens'=>$params['childrens'],
        'min_price'=>$params['min_price'],
        'max_price'=>$params['max_price']        
    );
    $result = $this->home_model->bookNow($data);
    $this->response($result, 200); 
}

function getPackageDetails_get(){
    $name=  $this->get('name');
    $result = $this->package_model->getPackageDetails($name);
    $this->response($result, 200);  
  }
 #------------------------------ Package End -----------------------------------#

}