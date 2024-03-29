<?php
  class Content_model extends CI_Model {

    public function __construct(){
       $this->load->database();
      }



      public function getAllStock($status){
        $query = $this->db->query("SELECT s.`id` as 'stock_id', sa.`id` as 'sale_id',sa.`cust_id`, b.`name` as `brand`, m.name as `model`, s.`color`, s.`purchase_date`, s.`price`, s.`soldstatus`, s.`date`, s.`user`, s.`imei1`, s.`imei2`, u.`first_name`, u.`last_name` FROM `stock` s LEFT OUTER JOIN brand b ON s.brand=b.id  LEFT OUTER JOIN model m ON s.`model`=m.id LEFT OUTER JOIN sale sa ON sa.imei1=s.imei1 LEFT OUTER JOIN user u ON u.id=sa.cust_id WHERE s.soldstatus=$status ORDER BY s.id DESC");
        $obj = new stdClass();
        if (!$query){
          $obj->value = false;
         $obj->message ="Data not found" ;
          return $obj ;
           }else{
          $obj->value = true;
          $obj->data = $query->result_array();
          return $obj ;
        }
      }





   public function createBrand($data){
     $brandname =ucfirst($data["name"]);
     $query = $this->db->query("SELECT * FROM brand WHERE `name`='$brandname'")->row();
       $obj = new stdClass();
if($query){
  $obj->value = false;
  $obj->message ="Brand name already exist, please select from dropdown list" ;
   return $obj ;
  
}else{
  $this->db->insert('brand',$data);
    if ($this->db->affected_rows() != 1){
      $obj->value = false;
     $obj->message ="Brand not created, please tray again" ;
      return $obj ;
   
    }else{
      $obj->value = true;
      $obj->message ="Brand Added successfully!" ;
      $obj->id =$this->db->insert_id();
      return $obj ;
    }
}
 
}


public function createID($data){
  $iddname =ucfirst($data["name"]);
  $query = $this->db->query("SELECT * FROM ids WHERE `name`='$iddname'")->row();
    $obj = new stdClass();
if($query){
$obj->value = false;
$obj->message ="ID name already exist, please select from dropdown list" ;
return $obj ;

}else{
$this->db->insert('ids',$data);
 if ($this->db->affected_rows() != 1){
   $obj->value = false;
  $obj->message ="ID not added, please tray again" ;
   return $obj ;

 }else{
   $obj->value = true;
   $obj->message ="ID Added successfully!" ;
   $obj->id =$this->db->insert_id();
   return $obj ;
 }
}

}

   public function createModel($data){
    $modelname =ucfirst($data["name"]);
    $query = $this->db->query("SELECT * FROM model WHERE `name`='$modelname'")->row();
      $obj = new stdClass();
if($query){
 $obj->value = false;
 $obj->message ="model name already exist, please select from dropdown list" ;
  return $obj ;
 
}else{
    $this->db->insert('model',$data);
 $obj = new stdClass();
 if ($this->db->affected_rows() != 1){
   $obj->value = false;
  $obj->message ="Model not created, please tray again" ;
   return $obj ;

 }else{
   $obj->value = true;
   $obj->id =$this->db->insert_id();
   $obj->message ="Model Added successfully!" ;
   return $obj ;
 }
}
}
   public function createStock($data){
    if($this->content_model->checkIMEI($data['imei1'])->value){
    $this->db->insert('stock',$data);
 $obj = new stdClass();
 if ($this->db->affected_rows() != 1){
   $obj->value = false;
  $obj->message ="Insertion failed" ;
   return $obj ;

 }else{
   
   $obj->value = true;
   $obj->message ="Stock Added successfully!" ;
   return $obj ;
 }
}else{
  $obj->value = false;
   $obj->message ="IMEI number already exists. Please enter correct IMEI number." ;
   return $obj ;
}
}

public function checkIMEI($imei){
  $query = $this->db->query("select * from stock where imei1='$imei' OR imei2='$imei2'");
  $obj = new stdClass();
  if($query->num_rows() > 0){
    $obj->value = false;
    $obj->message ="IMEI number already exists. Please enter correct IMEI number." ;
    return $obj ;
  }else{
    $obj->value = true;
    return $obj ;
 }
}

public function updateContentPage($data, $id){
 $this->db->where('id', $id);  
 $this->db->update('content', $data);  
 $obj = new stdClass();
if ($this->db->affected_rows() != 1){
 $obj->value = false;
$obj->message ="Updation failed" ;
 return $obj ;

}else{
 $obj->value = true;
 $obj->message ="Content page updated successfully!" ;
 return $obj ;
}
}


public function deleteContent($id){
  $query= $this->db->query("delete from content where id=$id");
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

 public function search($term){
   $query=$this->db->query("select * from product where name_english like '%$term%'");
   $obj = new stdClass();
   if (!$query){
     $obj->value = false;
    $obj->message ="Records not found" ;
     return $obj ;
 
   }else{
     $obj->value = true;
     $obj->data = $query->result_array();
     return $obj ;
   }
 }

}


?>