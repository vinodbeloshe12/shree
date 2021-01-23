<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];
header("Access-Control-Allow-Origin:  $http_origin");
// header("Access-Control-Allow-Origin:  $http_origin");
// array holding allowed Origin domains
// if ($http_origin == "http://192.168.0.32" ||
//     $http_origin == "http://localhost:6500" ||
//     $http_origin == "http://192.168.0.25" ||
//     $http_origin == "http://www.server4.com")
// {
//     header("Access-Control-Allow-Origin: $http_origin");
// }
//  header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
require(APPPATH.'/libraries/REST_Controller.php');
require APPPATH . 'libraries/Format.php';
 // use namespace
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller{
    var $serverIp = 'http://localhost/Shree/ShreeBackend/';
  
    public function __construct()
    {
        parent::__construct();
        $imageServer = 'http://localhost/Shree/ShreeBackend/uploads/';
        $this->config->set_item('imageServer', $imageServer);
         // $this->load->library('session');
    }


//register user
public function registerUser_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
     $fname= $params['first_name'];
     $lname= $params['last_name'];
     $mobile= $params['mobile'];
     $alternate_mobile= $params['alternate_mobile'];
     // $gender= $params['gender'];
     $dob= $params['dob'];
     $email=$params['email'];     
     $current_address=$params['current_address'];     
     $permanent_address=$params['permanent_address'];     
    //  $username=$params['username'];       
    if($params['role']){
        $role= $params['role'];
      }   else{
       $role=3;
      }   
      if($params['status']){
        $status= $params['status'];
      }   else{
       $status=3;
      }     
     $result = $this->user_model->register($fname,$lname,$mobile,$alternate_mobile,$dob,$email,$role,$status,$current_address,$permanent_address);
     $this->response($result, 200);      
}

//update user
public function updateUser_post(){
 $params = json_decode(file_get_contents('php://input'), TRUE);
  $id= $params['id'];
  $fname= $params['first_name'];
  $lname= $params['last_name'];
  $mobile= $params['mobile'];
  $alternate_mobile= $params['alternate_mobile'];
  // $gender= $params['gender'];
  $dob= $params['dob'];
  $email=$params['email'];     
  $username='';       
  $current_address=$params['current_address'];       
  $permanent_address=$params['permanent_address'];       
  $password=$params['password']; 
  if($params['role']){
    $role= $params['role'];
  }   else{
   $role=3;
  }   
  if($params['status']){
    $status= $params['status'];
  }   else{
   $status=3;
  }
  $result = $this->user_model->updateUser($id,$fname,$lname,$mobile,$alternate_mobile,$dob,$email,$username,$password,$current_address,$permanent_address,$role,$status);
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


      //submit pd
      public function savePd_post(){
        $params = json_decode(file_get_contents('php://input'), TRUE);
            $name= $params['name'];
            $email=$params['email'];     
            $phone=$params['phone'];       
            $gender=$params['gender']; 
            $id=$this->session->userData->data['id'];       
            $result = $this->user_model->savePd($id,$name,$email,$phone,$gender);
            $this->response($result, 200);      
       }

       //submit billing details
       public function updateBilling_post(){
        $params = json_decode(file_get_contents('php://input'), TRUE);
            $billingaddress= $params['billingaddress'];
            $billingpincode=$params['billingpincode'];     
            $billingcity=$params['billingcity'];       
            $billingstate=$params['billingstate']; 
            $id=$this->session->userData->data['id'];      
            $result = $this->user_model->updateBilling($id,$billingaddress,$billingpincode,$billingcity,$billingstate);
            $this->response($result, 200);      
       }

       //submit shipping details
       public function updateShipping_post(){
        $params = json_decode(file_get_contents('php://input'), TRUE);
            $shippingaddress= $params['shippingaddress'];
            $shippingpincode=$params['shippingpincode'];     
            $shippingcity=$params['shippingcity'];       
            $shippingstate=$params['shippingstate']; 
            $id=$this->session->userData->data['id'];      
            $result = $this->user_model->updateShipping($id,$shippingaddress,$shippingpincode,$shippingcity,$shippingstate);
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
         $result = $this->session->userData;
        $id=$this->session->userData->data['id'];   
        $result = $this->user_model->getUserDetails($id);
         $this->response($result, 200); 
        }else{
        $obj->value=false;
        $obj->message="User Not Logged in";
        $this->response($obj, 200); 
        }
    }

    // function getAllUsers_get(){
    //     $obj = new stdClass();
    //     if($this->session->userData){
    //     // $status=  $this->get('status');            
    //     $role=  $this->get('role'); 
    //     $result = $this->user_model->getAllUsers($role);
    //      $this->response($result, 200); 
    //     }
    // }

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


    function getIdProofDetails_get(){
        $obj = new stdClass();
        if($this->session->userData){
        $id=  $this->get('id');
        $result = $this->user_model->getIdProofDetails($id);
        $this->response($result, 200);  
       }else{
        $obj->value=false;
        $obj->message="User Not Logged in";
        $this->response($obj, 200); 
        }
    }

    function getUserDetailsById_get(){
        $obj = new stdClass();
        if($this->session->userData){
        $id=  $this->get('id');
        $result = $this->user_model->getUserDetailsById($id);
        $this->response($result, 200);  
       }else{
        $obj->value=false;
        $obj->message="User Not Logged in";
        $this->response($obj, 200); 
        }
    }

#------------------------------ Wishlist Start ----------------------------# 

function getWatchlist_get(){
    $result = $this->productwatch_model->getWatchlist();
    $this->response($result, 200);  
}


function addToWatchlist_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    if($this->session->userData){
    $data = array(
        'product'=>$params['product_id'],
        'user'=>$this->session->userData->data['id']     
    );
    $result = $this->productwatch_model->addToWatchlist($data);
    $this->response($result, 200); 
}else{
    $obj = new stdClass();
    $obj->value=false;
    $obj->message="Please Log in to continue";
    $this->response($obj, 200); 
}
 
}


//delete cart
function deleteWatchlist_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $id=  $params['id'];
    if($this->session->userData){
     $user=$this->session->userData->data['id'];
     $result = $this->productwatch_model->deleteWatchlist($id,$user);
     $this->response($result, 200); 
    }else{
        $obj = new stdClass();
        $obj->value=false;
        $obj->message="Please Log in to continue";
        $this->response($obj, 200); 
    }

 }
#------------------------------ Wishlist End ----------------------------# 





#------------------------------ Product Start ----------------------------# 
function getAllProduct_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $result = $this->product_model->getAllProduct($params);
    $this->response($result, 200); 
}
 #------------------------------ Product End -----------------------------------#



#------------------------------ Cart Start ----------------------------#  
//create cart 
public function addToCart_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
       $data = array(
        'product_id'=>$params['product_id'],
        'quantity'=>$params['quantity'] ?$params['quantity']:1   
        // 'quantity'=>$this->input->get_post('quantity')     
    );
        $result = $this->cart_model->addToCart($data);
        $this->response($result, 200); 
   
}

   //update cart 
   public function updateCart_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $id = $params['id'];
       $data = array(
        'product_id'=>$params['product_id'],
        'quantity'=>$params['quantity']       
    );
    $obj = new stdClass();
    if($this->session->userData){
    $result = $this->cart_model->updateCart($data,$id);
    $this->response($result, 200); 
    }else{
    $result = $this->cart_model->updateGuestUserCart($data,$id);
    $this->response($result, 200); 
    }
   }

    //get cart 
    function getCart_get(){
        $user = $this->session->userData->data['id'];
        $obj = new stdClass();
        if($this->session->userData){
        $result = $this->cart_model->getCart($user);
        $this->response($result, 200); 
        }else{
        $result = $this->cart_model->getGuestUserCart($lang);
        $this->response($result, 200); 
        }
        
    }

     //delete cart
   function deleteCart_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $id=  $params['id'];
    if($this->session->userData){
     $user=$this->session->userData->data['id'];
     $result = $this->cart_model->deleteCart($id,$user);
     $this->response($result, 200); 
    }else{
     $result = $this->cart_model->deleteGuestUserCart($id);
     $this->response($result, 200); 
    }

 }

     // to check product already in cart
     function checkCart_get(){
        $product_id=  $this->get('product_id');
        $user = $this->session->userData->data['id'];
        $obj = new stdClass();
        if($this->session->userData){
         $result = $this->cart_model->checkCart($product_id,$user);
         $this->response($result, 200); 
        }else{
        $obj->value=false;
        $obj->message="Please Login to continue";
        $this->response($obj, 200); 
        }
      }



        #------------------------------ Order Start ------------------------# 

#------------------------------ Product Start ----------------------------# 
function getAllOrders_get(){
    $result = $this->order_model->getAllOrders();
    $this->response($result, 200); 
}
 #------------------------------ Product End -----------------------------------#
 function updateOrderStatus_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE); 
    $id=$params['id'];
    $orderstatus=$params['orderstatus'];
    $result = $this->order_model->updateOrderStatus($orderstatus,$id);
    $this->response($result, 200); 
   }

   //submit order
   function submitOrder_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $data = array(
        'user'=>$this->session->userData->data['id'],
        'name'=>$params['name'],
        'email'=>$params['email'],
        'billingname'=>$params['billingname'],
        'billingaddress'=>$params['billingaddress'],
        'billingcontact'=>$params['billingcontact'],
        'billingcity'=>$params['billingcity'],
        'billingstate'=>$params['billingstate'],
        'billingpincode'=>$params['billingpincode'],
        'billingcountry'=>$params['billingcountry'],
        'shippingcity'=>$params['shippingcity'],
        'shippingaddress'=>$params['shippingaddress'],
        'shippingname'=>$params['shippingname'],
        'shippingcountry'=>$params['shippingcountry'],
        'shippingcontact'=>$params['shippingcontact'],
        'shippingstate'=>$params['shippingstate'],
        'shippingpincode'=>$params['shippingpincode'],
        'trackingcode'=>$params['trackingcode'],
        'currency'=>1,
        'shippingmethod'=>$params['shippingmethod'],
        'orderstatus'=>$params['orderstatus'],
        'paymentmethod'=>$params['paymentmethod'],
        // 'transactionid'=>$params['transactionid']  
    );
    $obj = new stdClass();
    // if($this->session->userData){
    $result = $this->order_model->submitOrder($data);
    $this->response($result, 200); 
    // }else{
    // $obj->value=false;
    // $obj->message="Please Login to continue";
    // $this->response($obj, 200); 
    // }
   }

   //get orders based on user_id
function getOrderbyUserId_get(){
    $user_id=$this->session->userData->data['id'];
    $obj = new stdClass();
    if($this->session->userData){
    $result=$this->order_model->getOrderbyUserId($user_id);
    $this->response($result,200);
    }else{
    $obj->value=false;
    $obj->message="Please Login to continue";
    $this->response($obj, 200); 
    }
   
}
//get orders based on id
function getOrderbyId_get(){
    $id=$this->get('id');
    $result=$this->order_model->getOrderbyId($id);
    $this->response($result,200);
}
//delete orders based on Id(PK)
function deleteOrder_get(){
    $id=  $this->get('id');
    $result = $this->order_model->deleteOrder($id);
    $this->response($result, 200); 
    }
  #------------------------------ Order End -------------------------------#   



        #------------------------------ category Start ------------------------# 
  //get all category
function getAllCategory_get(){
    $result=$this->category_model->getAllCategory();
    $this->response($result,200);
}


// add create category
function createCategory_post(){
    
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
// }
      $data = array(
      'name'=>$this->input->get_post('name'),
      'description'=>$this->input->get_post('description'),
      'user'=>$this->session->userData->data['id'],
      'order'=>$this->input->get_post('order'),
      'status'=>$this->input->get_post('status'),
      'banner_image'=>$image
    //   'image_name'=>$this->config->item('imageServer').$image
  );
  $id =$this->input->get_post('id');
  $obj = new stdClass();
  if($this->session->userData){
       if($this->session->userData->data['accesslevel']=='1'){
           if($id){
               $result = $this->category_model->updateCategory($data,$id);
           }else{
               $result = $this->category_model->createCategory($data);
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
  

 //get category  by Id 
function getCategoryById_get(){
    $lang=$this->session->lang;
    $id=$this->get('id');
    $result=$this->category_model->getCategoryById($lang,$id);
    $this->response($result,200);
}

//read all products by passing category name
function getCategoryDetailsByName_get(){
    $lang=$this->session->lang;
    $name=$this->get('name');
    $result=$this->category_model->getCategoryDetailsByName($lang,$name);
    $this->response($result,200);
}

//delete category
function deleteCategory_get(){
    $id=  $this->get('id');
    $result = $this->category_model->deleteCategory($id);
    $this->response($result, 200); 
    }
#-----------------------------Category End----------------------#


#------------------------------ Product Start Admin----------------------------# 
function getAllProductAdmin_get(){
  
    $result = $this->product_model->getAllProductAdmin();
    $this->response($result, 200); 
}


// add product
function createProduct_post(){
    $image = array();
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
                   $uploadImgData[$i]['image_name'] = $imageData['file_name'];
                //    $uploadImgData[$i]['image_name'] = $this->config->item('imageServer').$imageData['file_name'];
                }
         }
         $id =$this->input->get_post('id');
            $data = array(
        'name'=>$this->input->get_post('name'),
        'category'=>$this->input->get_post('category'),
        'description'=>$this->input->get_post('description'),
        'size'=>$this->input->get_post('size'),
        'price'=>$this->input->get_post('price'),
        'discount'=>$this->input->get_post('discount'),
        'final_price'=>$this->input->get_post('final_price'),
        'realated'=>$this->input->get_post('realated'),
        'quantity'=>$this->input->get_post('quantity'),
        'metatitle'=>$this->input->get_post('metatitle'),
        'metadesc'=>$this->input->get_post('metadesc'),
        'metakeyword'=>$this->input->get_post('metakeyword'),
        'date'=>$this->input->get_post('date'),
        'status'=>$this->input->get_post('status'),
        'order'=>$this->input->get_post('order')?$this->input->get_post('order'):0,
        'user'=>$this->session->userData->data['id']   ,
        'images'=>$uploadImgData
    );
   if($id){
   $result = $this->product_model->updateProduct($data, $id);
    }else{
    $result = $this->product_model->createProduct($data);
   }
     $this->response($result, 200); 
  }

  function getProductById_get(){
    $id=  $this->get('id');
    $result = $this->product_model->getProductById($id);
    $this->response($result, 200);  
  }

//delete product 
  function deleteProduct_get(){
    $id=  $this->get('id');
    $result = $this->product_model->deleteProduct($id);
    $this->response($result, 200);  
  }
//delete product image
  function deleteProductImage_get(){
    $id=  $this->get('id');
    $result = $this->product_model->deleteProductImage($id);
    $this->response($result, 200);  
  }
 #------------------------------ Product End -----------------------------------#

#------------------------------ Navigation Start ----------------------------# 
function getNavigation_get(){
    $result = $this->home_model->getNavigation();
    $this->response(json_decode(json_encode($result, JSON_NUMERIC_CHECK)), 200); 
}
 #------------------------------ Navigation End -----------------------------------#


#------------------------------ Contact Start ----------------------------# 
function getContact_get(){
    $result = $this->home_model->getContact();
    $this->response(json_decode(json_encode($result, JSON_NUMERIC_CHECK)), 200); 
}

 #------------------------------ Contact End -----------------------------------#


#------------------------------ Subscribe Start ----------------------------# 
function getSubscribe_get(){
    $result = $this->user_model->getSubscribe();
    $this->response(json_decode(json_encode($result, JSON_NUMERIC_CHECK)), 200); 
}

    public function submitSubscribe_post(){
        $params = json_decode(file_get_contents('php://input'), TRUE);
              $email=$params['email'];     
              $result = $this->user_model->submitSubscribe($email);
            $this->response($result, 200);      
       }


function deleteSubscribe_get(){
    $id=  $this->get('id');
    $result = $this->home_model->deleteSubscribe($id);
    $this->response($result, 200);  
  }
 #------------------------------ Subscribe End -----------------------------------#
 
 
 #------------------------------ Brand Start -----------------------------------#
 function getAllBrands_get(){
    $result = $this->user_model->getAllBrands();
    $this->response($result, 200);  
}


   //create brand
   public function createBrand_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
     $data = array(
        'name'=>$params['name'],
        'user'=>$this->session->userData->data['id']
     );
       $result = $this->content_model->createBrand($data);
     $this->response($result, 200);      
}
 #------------------------------ Brand End -----------------------------------#

 #------------------------------ Model Start -----------------------------------#
 function getAllModels_get(){
    $brand=  $this->get('brand');
    $result = $this->user_model->getAllModels($brand);
    $this->response($result, 200);  
}

//create model
public function createModel_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
     $data = array(
        'name'=>$params['name'],
        'brand'=>$params['brand'],
        'user'=>$this->session->userData->data['id']
     );
       $result = $this->content_model->createModel($data);
     $this->response($result, 200);      
}
 #------------------------------ Model End -----------------------------------#


 #------------------------------ Stock Start -----------------------------------#
 function getAllStock_get(){
    $result = $this->content_model->getAllStock();
    $this->response($result, 200);  
}
 function getAllSales_get(){
    $result = $this->user_model->getAllSales();
    $this->response($result, 200);  
}
 function getAllUserData_get(){
    $result = $this->user_model->getAllUserData();
    $this->response($result, 200);  
}
 //create stock
public function createStock_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
     $data = array(
        'model'=>$params['model'],
        'brand'=>$params['brand'],
        'color'=>$params['color'],
        'purchase_date'=>$params['purchase_date'],
        'price'=>$params['price'],
        'quantity'=>$params['quantity'],
        'imei1'=>$params['imei1'],
        'imei2'=>$params['imei2'],
        'user'=>$this->session->userData->data['id']
     );
       $result = $this->content_model->createStock($data);
     $this->response($result, 200);      
}
 #------------------------------ Stock End -----------------------------------#



 


// add idprrof
function createIdProof_post(){
    $image = array();
    $target_path = './uploads/compress/';
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
                   $uploadImgData[$i]['image_name'] = $imageData['file_name'];

                  //new code
                  $config_r['source_image']   = './uploads/' . $imageData['file_name'];
                  $config_r['maintain_ratio'] = TRUE;
                  $config_t['create_thumb'] = FALSE;///add this
                  $config_r['width']   = 1200;
                  $config_r['height'] = 1200;
                  $config_r['quality']    = 70;
                  //end of configs
  
                  $this->load->library('image_lib', $config_r);
                  $this->image_lib->initialize($config_r);
                  if(!$this->image_lib->resize())
                  {
                      echo "Failed." . $this->image_lib->display_errors();
                   }
                  else
                  {
                      $image=$this->image_lib->dest_image;
                   }

                }
         }
         $id =$this->input->get_post('id');
            $data = array(
        'cust_id'=>$this->input->get_post('cust_id'),
        'id_type'=>$this->input->get_post('name'),
        'number'=>$this->input->get_post('number'),
        'user'=>$this->session->userData->data['id'],
        'images'=>$uploadImgData
    );
   if($id){
   $result = $this->user_model->updateIdproof($data, $id);
}else{
    $result = $this->user_model->createIdproof($data);
   }
     $this->response($result, 200); 
  }

    // add Transaction
function createTransaction_post(){
$params = json_decode(file_get_contents('php://input'), TRUE);
 $data = array(
  'cust_id'=>$params['cust_id'],
  'brand'=>$params['brand'],
 'model'=>$params['model'],
 'color'=>$params['color'],
 'imei1'=>$params['imei1'],
 'imei2'=>$params['imei2'],
 'price'=>$params['price'],
 'purchase_date'=>$params['purchase_date'],
 'payment_mode'=>$params['payment_mode'],
 'finance_name'=>$params['finance_name'],
 'intrest'=>$params['intrest'],
 'loan_amount'=>$params['loan_amount'],
 'down_payment'=>$params['down_payment'],
 'emi_amount'=>$params['emi_amount'],
 'ntenure'=>$params['ntenure'],
 'gtenure'=>$params['gtenure'],
 'emi_due_date'=>$params['emi_due_date'],
 'loan_number'=>$params['loan_number'],
  'emi_start_date'=>$params['emi_start_date'],
  'comment'=>$params['comment'],
  'feedback'=>$params['feedback'],
  'emi_end_date'=>$params['emi_end_date'] 
);
    $result = $this->user_model->createTransaction($data);
    $this->response($result, 200); 
}




  // add review
function createContact_post(){
$params = json_decode(file_get_contents('php://input'), TRUE);
 $data = array(
  'cust_id'=>$params['cust_id'],
  'fname'=>$params['fname'],
 'lname'=>$params['lname'],
  'relation'=>$params['relation'],
  'mobile'=>$params['mobile'] 
);
    $result = $this->user_model->createContact($data);
    $this->response($result, 200); 
 
}

function getTransactionDetails_get(){
    $id=  $this->get('id');
    $result = $this->user_model->getTransactionDetails($id);
    $this->response($result, 200);  
}

function getDashboardDetails_get(){
    $result = $this->user_model->getDashboardDetails();
    $this->response($result, 200);  
}
function getEMIDetails_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $result = $this->user_model->getEMIDetails($params);
    $this->response($result, 200);  
}

function getChartData_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
     $result = $this->user_model->getChartData($params);
    $this->response($result, 200);  
}

function deleteIdProofImage_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $id=$params['id'];
    $type=$params['id_type'];
    $imageid=$params['imageid'];
    $image_name=$params['image_name'];
     $result = $this->user_model->deleteIdProofImage($id,$type,$imageid,$image_name);
    $this->response($result, 200);  
}


function getMobileDetailsByImei_get(){
    $id=  $this->get('id');
    $result = $this->user_model->getMobileDetailsByImei($id);
    $this->response($result, 200);  
}
function deleteContact_get(){
    $id=  $this->get('id');
    $result = $this->user_model->deleteContact($id);
    $this->response($result, 200);  
}

function updateContact_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    $id = $params['id'];
       $data = array(
        'first_name'=>$params['fname'],       
        'last_name'=>$params['lname'],       
        'contact'=>$params['mobile'],       
        'relation'=>$params['relation']       
    );
   
    $result = $this->user_model->updateContact($data,$id);
    $this->response($result, 200);  
}

function downloadImage_post(){
    $params = json_decode(file_get_contents('php://input'), TRUE);
    print_r($params);
   // load download helder
   $this->load->helper('download');
   // read file contents
   $data = file_get_contents(base_url('/uploads/'.$params));
   print_r($data);
   force_download($filename, $data);  
   $this->response($data, 200);
}

}