<?php
  class Cart_model extends CI_Model {

    public function __construct(){
       $this->load->database();
      }


//create cart
public function addToCart($data){
  $user =$data['user_id'];
  $this->db->insert('cart',$data);
  $query=$this->db->query("select SUM(quantity) AS TotalItemsInCart FROM cart WHERE user_id=$user")->row();
  if ($this->db->affected_rows() != 1){
    $obj->value = false;
    $obj->TotalItemsInCart =$query->TotalItemsInCart;
    $obj->message ="Insertion failed" ;
    return $obj ;

  }else{
    $obj->value = true;
    $obj->TotalItemsInCart =$query->TotalItemsInCart;
    $obj->message ="Record inserted" ;
    return $obj ;
  }
}


//get cart
public function getCart($lang,$user){
if($lang=='en'){
  $query=$this->db->query("select c.`id`,p.quantity as 'stock',c.product_id,p.name_english as 'name',p.image, p.price , p.discount, (SELECT SUM(c.quantity) AS quantity FROM cart c where c.product_id=p.id and c.user_id=$user) as quantity, c.`user_id`, c.`date` FROM `cart` c LEFT JOIN product p ON p.id=c.product_id WHERE c.user_id=$user  GROUP BY p.id");  
}else{
  $query=$this->db->query("select c.`id`,p.quantity as 'stock',c.product_id,p.name_marathi as 'name',p.image, p.price , p.discount, (SELECT SUM(c.quantity) AS quantity FROM cart c where c.product_id=p.id and c.user_id=$user) as quantity, c.`user_id`, c.`date` FROM `cart` c LEFT JOIN product p ON p.id=c.product_id WHERE c.user_id=$user  GROUP BY p.id"); 
}
$obj = new stdClass();
$cartquery=$this->db->query("select SUM(quantity) AS TotalItemsInCart FROM cart WHERE user_id=$user")->row();
if($query->num_rows() > 0){
  $obj->value = true;
 $obj->TotalItemsInCart =$cartquery->TotalItemsInCart;
  $obj->data = $query->result_array();
  return $obj ;
}else{
  $obj->value = true;
  $obj->data = [];
  $obj->TotalItemsInCart =$cartquery->TotalItemsInCart;
  $obj->message ="your cart is empty" ;
  return $obj ;
}
}


  //delete cart
  public function deleteCart($id,$user){
    $query= $this->db->query("delete from cart where product_id=$id and user_id=$user");
    $obj = new stdClass();
    $query=$this->db->query("select SUM(quantity) AS TotalItemsInCart FROM cart WHERE user_id=$user")->row();
     if ($this->db->affected_rows() != 1){
       $obj->value = false;
       $obj->TotalItemsInCart =$query->TotalItemsInCart;
      $obj->message ="Deletion failed" ;
       return $obj ;
   
     }else{
      $obj->value = true;
      $obj->TotalItemsInCart =$query->TotalItemsInCart;
       $obj->message =" Records deleted,1 row affected" ;
       return $obj ;
     }
   }

}
?>