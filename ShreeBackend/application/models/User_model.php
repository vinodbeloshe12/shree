<?php
class User_model extends CI_model{
    public function __construct(){
        $this->load->database();
       }

// public function getAllUsers($role,$status){
//     $query = $this->db->query("SELECT u.`id`, u.`name`, u.`first_name`, u.`last_name`, u.`mobile`, u.`role`, u.`email`, u.`date`, u.`dob`, u.`status`, u.`username`, u.`password`,(select number from idproof where id_type='pancard' and u.id=idproof.cust_id LIMIT 1) as 'pancard',(select number from idproof where id_type='aadharcard' and u.id=idproof.cust_id LIMIT 1) as 'aadharcard' FROM `user` u WHERE u.`role`=$role and u.status=$status ORDER BY u.id DESC");
//     $obj = new stdClass();
//    if($query->num_rows() > 0){
//      $obj->value = true;
//      $obj->data = $query->result_array();
//      return $obj ;
//    }else{
//      $obj->value = false;
//      $obj->data = [];
//      $obj->message ="Records not found" ;
//      return $obj ;
//    }
// }
public function getSubscribe(){
    $query = $this->db->query('select * FROM `newsletter` order by id desc');
    $obj = new stdClass();
   if($query->num_rows() > 0){
     $obj->value = true;
     $obj->data = $query->result_array();
     return $obj ;
   }else{
     $obj->value = false;
     $obj->data = [];
     $obj->message ="Records not found" ;
     return $obj ;
   }
}

public function login($username, $password){
       $query = $this->db->query("SELECT `id`, `name`, `first_name`, `last_name`, `mobile`, `role`, `email`, `date`, `dob`, `status`, `username`, `password` FROM `user` WHERE  username='$username' and password='$password'");
       $obj = new stdClass();
       if($query->num_rows() > 0){
        $obj->value = true;
        $obj->data = $query->result_array()[0];
        return $obj ;
       }else{
        $obj->value = false;
        $obj->data = [];
        $obj->message ="Invalid Username/Password" ;
        return $obj ;
       }
   
}



public function submitSubscribe($email){
  // if (valid_email($email)){
$checkSub = $this->db->query("select * from newsletter where email='$email'");
echo $query->num_rows();
$query = $this->db->query("insert into newsletter(email) values($email)");
  $obj = new stdClass();
  if($query){
    $obj->value = true;
    $obj->message = "Thank You. Please check your inbox to confirm your email address";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  } 
  // }
  // else{
  //   $obj->value = false;
  //   $obj->field = "email";
  //   $obj->message ="Please enter valid Email Address." ;
  //   return $obj ;
  // }
}


public function submitContact($name,$email,$phone,$subject,$message){
  $obj = new stdClass();
  if(trim($name, " ") && trim($phone, " ") && trim($email, " ") && trim($subject, " ") && trim($message, " ")){
    $this->load->helper('email');
    if (valid_email($email)){
// $query=$this->db->query("insert into contact (`name`, `phone`, `email`, `subject`, `message`) VALUES('$name','$phone','$email','$subject','$message') ");
$data=array("name" => $name,"email" => $email,"phone" => $phone,"subject" => $subject,"message" => $message);
$query=$this->db->insert( "contact", $data );
if($query){
  $id=$this->db->insert_id();
  $data = $this->db->query("select * from contact where id=$id")->row();
  $sendData['data'] = $data;
  $viewcontent = $this->load->view('emailers/enquiry', $sendData, true);
  $this->email_model->emailer($viewcontent,'New Enquiry - Mukesh Jewellers',"makedigitaldesigners@gmail.com","");
  $obj->value = true;
  $obj->message = "Thank you for getting in touch! We will get back to you shortly.";
  return $obj ;
}else{
  $obj->value = false;
  $obj->message ="Something went wrong, please try again later." ;
  return $obj ;
} 
}else{
      $obj->value = false;
      $obj->field = "email";
      $obj->message ="Please enter valid Email Address." ;
      return $obj ;
    }
  }
  else{
    $obj->value = false;
    $obj->message ="All fields are mandatory." ;
    return $obj ;
  }
}


public function submitPersonalDetails($id,$fname,$lname,$phone,$email,$billing_address,$billing_country,$billing_city,$billing_state,$billing_pincode,$shipping_address,$shipping_country,$shipping_city,$shipping_state,$shipping_pincode){
$data=array("firstname" => $fname,"lastname" => $lname,"phone" => $phone,"email" => $email,"billing_address" => $billing_address,"billing_country" => $billing_country,"billing_city" => $billing_city,"billing_state" => $billing_state,"billing_pincode" => $billing_pincode,"shipping_address" => $shipping_address,"shipping_country" => $shipping_country,"shipping_city" => $shipping_city,"shipping_state" => $shipping_state,"shipping_pincode" => $shipping_pincode);
$this->db->where( "id", $id );
$query=$this->db->update( "user", $data );
$obj = new stdClass();
if($query){
  $obj->value = true;
  $obj->message = "record updated";
  return $obj ;
}else{
  $obj->value = false;
  $obj->message ="Something went wrong, please try again later." ;
  return $obj ;
} 
}


public function savePd($id,$name,$email,$phone,$gender){
  $data=array("name" => $name,"email" => $email,"phone" => $phone,"gender" => $gender);
  $this->db->where( "id", $id );
  $query=$this->db->update( "user", $data );
  $obj = new stdClass();
  if($query){
    $obj->value = true;
    $obj->message = "record updated";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  } 
}

public function updateBilling($id,$billingaddress,$billingpincode,$billingcity,$billingstate){
  $data=array("billingaddress" => $billingaddress,"billingcountry" => $billingcountry,"billingcity" => $billingcity,"billingstate" => $billingstate,"billingpincode" => $billingpincode);
  $this->db->where( "id", $id );
  $query=$this->db->update( "user", $data );
  $obj = new stdClass();
  if($query){
    $obj->value = true;
    $obj->message = "record updated";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  } 
}

public function updateShipping($id,$shippingaddress,$shippingpincode,$shippingcity,$shippingstate){
  $data=array("shippingaddress" => $shippingaddress,"shippingcountry" => $shippingcountry,"shippingcity" => $shippingcity,"shippingstate" => $shippingstate,"shippingpincode" => $shippingpincode);
  $this->db->where( "id", $id );
  $query=$this->db->update( "user", $data );
  $obj = new stdClass();
  if($query){
    $obj->value = true;
    $obj->message = "record updated";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  } 
}



public function getUserDetails($id){
  $query = $this->db->query("select * from user where id=$id")->row();
  if($query){
    $obj->value = true;
    $obj->data =$query ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  }
}


public function register($fname,$lname,$mobile,$alternate_mobile,$dob,$email,$role,$status,$current_address,$permanent_address){
  $obj = new stdClass();
  // if(trim($email, " ")){
  // if($this->user_model->checkUserEmail($email)->value){
    // if($this->user_model->checkUser($username)->value){
 $query = $this->db->query("insert into user (`name`, `first_name`, `last_name`, `mobile`, `alternate_mobile`, `role`,`status`, `email`, `dob`,`current_address`,`permanent_address`)values('$fname.' '.$lname','$fname','$lname','$mobile','$alternate_mobile',$role,$status,'$email','$dob','$current_address','$permanent_address')");
 if($query){
  $id=$this->db->insert_id();
  $this->user_model->createPassword($id);
  $obj->value = true;
  $obj->userId = $id;
  $obj->message = "User registered successfully!";
  return $obj ;
}else{
  $obj->value = false;
  $obj->message ="Something went wrong, please try again later." ;
  return $obj ;
}
// }else{
//   return $this->user_model->checkUser($username);
// }
// }else{
// return $this->user_model->checkUserEmail($email);
// }
// }else{
//   $obj->value = false;
//   $obj->message ="Email is required" ;
//   return $obj ;
// }
}

public function updateUser($id,$fname,$lname,$mobile,$alternate_mobile,$dob,$email,$username,$password,$current_address,$permanent_address,$role,$status){
  $data=array("first_name" => $fname,"last_name" => $lname,"mobile" => $mobile,"email" => $email,"dob" => $dob,"alternate_mobile" => $alternate_mobile,"username" => $username,"password" => $password,"current_address" => $current_address,"permanent_address" => $permanent_address,"role" => $role,"status"=> $status);
  $this->db->where( "id", $id );
  $query=$this->db->update( "user", $data );
  $obj = new stdClass();
  if($query){
    $obj->value = true;
    $obj->message = "record updated";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="Something went wrong, please try again later." ;
    return $obj ;
  } 
  }

public function createPassword($id){
  $obj = new stdClass();
  $this->load->helper('string');
  $passwrod=random_string('alnum',10);
  $query = $this->db->query("update user set password='$passwrod' where id=$id");
  if($query){
    // $data = $this->db->query("select * from user where id=$id")->row();
    // $sendData['data'] = $data;
    // $viewcontent = $this->load->view('emailers/registeruser', $sendData, true);
    // $this->email_model->emailer($viewcontent,'Welcome to Mukesh Jewellers',$data->email,"");
    $obj->value = true;
    $obj->message = "User registered successfully!";
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message = "Error while generating password, please try again later.";
    return $obj ;
  }
}

public function checkUser($username){
  $query = $this->db->query("select * from user where username='$username'");
  $obj = new stdClass();
  if($query->num_rows() > 0){
    $obj->value = false;
    $obj->field = "username";
    $obj->message ="Username already exists. Please use a different username." ;
    return $obj ;
  }else{
    $obj->value = true;
    return $obj ;
 }
}
public function checkUserEmail($email){
  $this->load->helper('email');
 if (valid_email($email))
 {
  $query = $this->db->query("select * from user where email='$email'");
  $obj = new stdClass();
  if($query->num_rows() > 0){
    $obj->value = false;
    $obj->field = "email";
    $obj->message ="Email Address already registerd. Please use a different Email." ;
    return $obj ;
  }else{
    $obj->value = true;
    return $obj ;
 }
 }
 else
 {
$obj->value = false;
 $obj->field = "email";
 $obj->message ="Please enter valid Email Address." ;
 return $obj ;
 }
  
}

public function getUserDetailsById($id){
  $query = $this->db->query("SELECT * FROM user WHERE id=$id")->row();
  $idproof = $this->db->query("SELECT i.`id`,id.id as 'imageid', i.`cust_id`, i.`id_type`, i.`number`, id.`image_name`, i.`date`, i.`user` FROM `idproof` i LEFT JOIN idproof_images id ON i.id=id.cust_id WHERE i.cust_id=$id")->result_array();
  $contacts = $this->db->query("SELECT * FROM `contacts` WHERE cust_id=$id")->result_array();
  $transaction = $this->db->query("SELECT * FROM `sale` WHERE cust_id=$id ORDER BY purchase_date DESC")->result_array();
  if($query){
    $obj->value = true;
    $obj->details =$query ;
    $obj->idproof =$idproof ;
    $obj->contacts =$contacts ;
    $obj->transaction =$transaction ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="User not found." ;
    return $obj ;
  }
}


public function getIdProofDetails($id){
  $query = $this->db->query("SELECT i.`id`, i.`cust_id`, i.`id_type`, i.`number`, id.`image_name`, i.`date`, i.`user` FROM `idproof` i LEFT JOIN idproof_images id ON i.id=id.cust_id WHERE i.cust_id=$id")->result_array();
  if($query){
    $obj->value = true;
    $obj->data =$query ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->data = [];
    $obj->message ="Data not found" ;
    return $obj ;
  }
}
public function getTransactionDetails($id){
  $query = $this->db->query("SELECT * FROM `sale` WHERE id=$id")->row();
  if($query){
    $obj->value = true;
    $obj->data =$query ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->data = [];
    $obj->message ="Data not found" ;
    return $obj ;
  }
}
public function getAllSales(){
  $query = $this->db->query("SELECT s.`id`, s.`cust_id`,u.name, s.`brand`, s.`model`, s.`color`, s.`imei1`, s.`imei2`, s.`purchase_date`, s.`price`, s.`payment_mode`, s.`user` FROM `sale` s LEFT JOIN user u ON s.cust_id=u.id ORDER BY s.purchase_date DESC")->result_array();
  if($query){
    $obj->value = true;
    $obj->data =$query ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->data = [];
    $obj->message ="Data not found" ;
    return $obj ;
  }
}
public function getAllUserData(){
  $query = $this->db->query("SELECT u.id, u.name, u.mobile, u.email, i.number, (select number from idproof where id_type='pancard' and u.id=idproof.cust_id LIMIT 1) as 'pancard' ,(select number from idproof where id_type='aadharcard' and u.id=idproof.cust_id LIMIT 1) as 'aadharcard' FROM `user` u LEFT JOIN idproof i ON u.id=i.user")->result_array();
  if($query){
    $obj->value = true;
    $obj->data =$query ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->data = [];
    $obj->message ="Data not found" ;
    return $obj ;
  }
}


public function getAllBrands(){
  $query = $this->db->query("SELECT * FROM `brand`")->result_array();
  if($query){
    $obj->value = true;
    $obj->data =$query ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->data = [];
    $obj->message ="Data not found" ;
    return $obj ;
  }
}

public function getAllModels($brand){
  $query = $this->db->query("SELECT * FROM `model` where brand=$brand")->result_array();
  if($query){
    $obj->value = true;
    $obj->data =$query ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->data = [];
    $obj->message ="Data not found" ;
    return $obj ;
  }
}




public function createIdproof($data){
  // $string_version = implode(',', $data)
 $insertData=array("cust_id" => $data['cust_id'],"id_type" =>  $data['id_type'],"number" =>  $data['number'],"user" =>  $data['user']);
 $this->db->insert('idproof',$insertData);
 $obj = new stdClass();
 if ($this->db->affected_rows() != 1){
   $obj->value = false;
  $obj->message ="Insertion failed" ;
   return $obj ;
 }else{
  $id=$this->db->insert_id();
   $type =$data['id_type'];
   if($data['images']){
     $this->user_model->insertIdproofImages($data['images'],$id,$type);
   }
   $obj->value = true;
   $obj->message ="Record inserted" ;
   return $obj ;
 }
}

public function insertIdproofImages($data,$id,$type){
  $obj = new stdClass();
 $DataArr = array();
 foreach ($data as $key => $value){
     array_push($DataArr,array("image_name" => $value['image_name'],"type" => $type,"cust_id" => $id));
 }
 $this->db->insert_batch('idproof_images',$DataArr);
 if ($this->db->affected_rows() != 1){
   $obj->value = false;
  $obj->message ="Insertion failed" ;
   return $obj ;
 }else{
   $obj->value = true;
   $obj->message ="Record inserted" ;
   return $obj ;
 }
}


public function createContact($data){
 $insertData=array("cust_id" => $data['cust_id'],"relation" =>  $data['relation'],"first_name" =>  $data['fname'],"last_name" =>  $data['lname'],"user" =>  $this->session->userData->data['id'],"contact" =>  $data['mobile']);
  $this->db->insert('contacts',$insertData);
  $obj = new stdClass();
  if ($this->db->affected_rows() != 1){
    $obj->value = false;
   $obj->message ="Insertion failed" ;
    return $obj ;

  }else{
    $obj->value = true;
    $obj->message ="Record inserted" ;
    return $obj ;
  }
}

public function createTransaction($data){
   $insertData=array("cust_id" => $data['cust_id'],"brand" =>  $data['brand'],"model" =>  $data['model'],"color" =>  $data['color'],"user" =>  $this->session->userData->data['id'],"imei1" =>  $data['imei1'],"imei2" =>  $data['imei2'],"price" =>  $data['price'],"purchase_date" =>  $data['purchase_date'],"payment_mode" =>  $data['payment_mode'],"finance_name" =>  $data['finance_name'],"intrest" =>  $data['intrest'],"loan_amount" =>  $data['loan_amount'],"down_payment" =>  $data['down_payment'],"emi_amount" =>  $data['emi_amount'],"ntenure" =>  $data['ntenure'],"gtenure" =>  $data['gtenure'],"emi_due_date" =>  $data['emi_due_date'],"loan_number" =>  $data['loan_number'],"emi_start_date" =>  $data['emi_start_date'],"emi_end_date" =>  $data['emi_end_date'],"comment" =>  $data['comment'],"feedback" =>  $data['feedback']);
   $this->db->insert('sale',$insertData);
   $obj = new stdClass();
   if ($this->db->affected_rows() != 1){
     $obj->value = false;
    $obj->message ="Insertion failed" ;
     return $obj ;
 
   }else{
   $imei1 =$data['imei1'];
    $query = $this->db->query("update stock set soldstatus=1 where imei1='$imei1'");
     $obj->value = true;
     $obj->message ="Record inserted" ;
     return $obj ;
   }
 }

//  public function deleteIdProofImage($id,$type,$imageid,$image_name){
//   $q="select * from idproof_images where cust_id=$id and type='$type'";
//   $iddata= $this->db->query($q)->result_array();
//   $file = 'backend/uploads/'.$image_name;
//   if(sizeof($iddata)==1){
//     $queryid= $this->db->query("delete from idproof where id=$id");
//     $query= $this->db->query("delete from idproof_images where id=$imageid");
//     $obj = new stdClass();
//     console.log($this->db);
//      if ($this->db->affected_rows() == 1){
//        $obj->value = false;
//       $obj->message ="Deletion failed" ;
//        return $obj ;
//      }else{
//       if(is_file($file)){
//         unlink($file); // delete file
//       }
//        $obj->value = true;
//        $obj->message =" Records deleted,1 row affected" ;
//        return $obj ;
//      }
//   }else{
//     $query= $this->db->query("delete from idproof_images where id=$imageid");
//     $obj = new stdClass();
//      if ($this->db->affected_rows() != 1){
//        $obj->value = false;
//       $obj->message ="Deletion failed" ;
//        return $obj ;
   
//      }else{
//       if(is_file($file)){
//         unlink($file); // delete file
//       }
//        $obj->value = true;
//        $obj->message =" Records deleted,1 row affected" ;
//        return $obj ;
//      }
//   }
 
//  }


public function deleteIdProofImage($id,$type,$image_name,$imageid){
  if(file_exists($id,$type,$image_name,$imageid))
  {
  unlink($id,$type,$image_name,$imageid);
  }

}



public function getDashboardDetails(){
  $opening_stock = $this->db->query("SELECT count(id) as 'opening_stock' FROM `stock` where DATE(purchase_date)<CURRENT_DATE")->row();
  $purchase_stock = $this->db->query("SELECT count(id) as 'purchase_stock' FROM `stock` where DATE(purchase_date)=CURRENT_DATE")->row();
  $sale_stock = $this->db->query("SELECT count(id) as 'sale_stock' FROM `sale` where DATE(purchase_date)=CURRENT_DATE")->row();
  $total_stock = $this->db->query("SELECT count(id) as 'total_stock' FROM `stock`")->row();
  $total_sale = $this->db->query("SELECT count(id)  as 'total_sale' FROM `sale`")->row();
  $total_user = $this->db->query("SELECT COUNT(id) as 'total_user' FROM user")->row();
  $brands = $this->db->query("SELECT b.id,b.name,(SELECT COUNT(s.brand) from stock s WHERE s.brand=b.id AND s.soldstatus=0) as 'count' from brand b")->result_array();
  $obj = new stdClass();
  if($opening_stock){
    $obj->value = true;
    $data->stock->opening_stock =$opening_stock->opening_stock ;
    $data->stock->purchase_stock =$purchase_stock->purchase_stock ;
    $data->stock->sale_stock =$sale_stock->sale_stock ;
    $data->stock->closing_stock =($opening_stock->opening_stock + $purchase_stock->purchase_stock) - $sale_stock->sale_stock;
    $data->stock->total_stock =$total_stock->total_stock ;
    $data->stock->total_sale =$total_sale->total_sale ;
    $data->stock->total_user =$total_user->total_user ;
    $data->brands =$brands ;
    $obj->data = $data;
     return $obj ;
  }else{
    $obj->value = false;
    $obj->message ="User not found." ;
    return $obj ;
  }
}


public function getChartData($dates){
  $obj = new stdClass();
  $purchaseData = array();
  $saleData = array();
 foreach ($dates as $key ){
     $purchase = $this->db->query("SELECT COUNT(id) as 'total' FROM `stock` WHERE DATE(purchase_date)='$key'")->row();
     $sale = $this->db->query("SELECT COUNT(id) as 'total' FROM `sale` WHERE DATE(purchase_date)='$key'")->row();
     array_push($purchaseData,$purchase->total);
     array_push($saleData,$sale->total);
   }
   $obj->value = true;
   $obj->purchase = $purchaseData;
   $obj->sale = $saleData;
   return $obj ;
}


public function getMobileDetailsByImei($id){
  $query = $this->db->query("SELECT b.`name` as brand, m.`name` as model, s.`color`, s.`imei1`, s.`imei2`, s.price,s.soldstatus from stock s LEFT OUTER JOIN brand b ON s.brand=b.id LEFT OUTER JOIN model m ON s.model=m.id
  WHERE s.imei1='$id' OR s.imei2='$id'")->row();
  $obj = new stdClass();
   if($query->soldstatus){
    $obj->value = false;
    $obj->data = [];
    $obj->message ="Mobile already sold !" ;
    return $obj ;
  }else{
    if($query){
      $obj->value = true;
      $obj->data =$query ;
      return $obj ;
    }else{
      $obj->value = false;
      $obj->data = [];
      $obj->message ="Mobile not found" ;
      return $obj ;
    }
  }
 
}

public function getEMIDetails($days){
  $emiData = array();
  foreach ($days as $key ){
    $q="SELECT s.`id`, s.`cust_id`,u.name, u.mobile, u.email, s.`brand`, s.`model`,s.finance_name, s.`imei1`, s.`imei2`, s.`purchase_date`,s.`emi_due_date`,s.emi_start_date,s.emi_end_date, s.`price`, s.`payment_mode`, s.`user` FROM `sale` s LEFT JOIN user u ON s.cust_id=u.id WHERE DAY(s.`emi_due_date`) ='$key' AND DATE(s.emi_start_date) <= CURRENT_DATE() AND DATE(s.emi_end_date) >= CURRENT_DATE() AND s.`payment_mode`='Loan' ";
    // echo $q;
  $query = $this->db->query($q)->result_array();
  if($query){
    $emiData= array_merge($emiData,$query);
  }
  }
  $obj = new stdClass();
 if($emiData){
    $obj->value = true;
    $obj->data =$emiData ;
    return $obj ;
  }else{
    $obj->value = false;
    $obj->data = [];
    $obj->message ="Data not found" ;
    return $obj ;
  }
}

public function deleteContact($id,$type){
  $query= $this->db->query("delete from contacts where id=$id");
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



 public function updateContact($data, $id){
  $this->db->where('id', $id);  
  $this->db->update('contacts', $data);  
  $obj = new stdClass();
 if ($this->db->affected_rows() != 1){
  $obj->value = false;
 $obj->message ="Updation failed" ;
  return $obj ;
 
 }else{
  $obj->value = true;
  $obj->message ="contact updated successfully!" ;
  return $obj ;
 }
 }


}
?>