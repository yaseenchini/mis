<?php
class Ordertracker_m extends CI_Model
{
  
  

    public function address()
    {
        $this->db->where('parent_id',0);
         $query=$this->db->get('address');
       return $query->result();
    }
    public function prepare_jstree_addresses(){
         $this->db->where('parent_id',0);
         $this->db->order_by('addr_id','asc');
         $query=$this->db->get('address');  
         $json = "[";
         foreach($query->result_array() as $row){
            $json.= '{"id":';
            $json.= $row['addr_id'];
            $json.= ','.'"text":"'.$row['title'].'"';
            //fetching first childrens

            $this->db->where('parent_id',$row['addr_id']);
            $this->db->order_by('addr_id','asc');
            $query_child1 = $this->db->get('address');
            if($query_child1->num_rows() > 0){
                
                $json.= ',"children":[';
                foreach($query_child1->result_array() as $row_child_1){
                    $json.= '{"id":';
                    $json.= $row_child_1['addr_id'];  
                    $json.= ','.'"text":"'.$row_child_1['title'].'" '; 
                    
                    //fetching 2nd child
                    $this->db->where('parent_id',$row_child_1['addr_id']);
                    $this->db->order_by('addr_id','asc');
                    $query_child2 = $this->db->get('address');
                    $json.=',"children":[';
                    if($query_child2->num_rows() > 0){ 
                        foreach($query_child2->result_array() as $row_child_2){
                        $json.='{"id":'.$row_child_2['addr_id'].',"text":"'.$row_child_2['title'].'"},';
                        }
                    }
                    $json = rtrim($json,",");
                    $json.=']';               
                    $json.='},';
                }
                $json = rtrim($json,",");
                $json.= ']';
            }              
                           
            $json.= "},";
         }
            //$json.="{";
            //$json.='"id":'+$rs['addr_id']+',"text":'+$rs['title']+'';
            //$json.="}";
         $json = rtrim($json,",");
         $json.= "]";
         echo $json;
               
    }
    public function get_child_address($parent_id)
    {
        $this->db->where('parent_id',$parent_id);
        $this->db->order_by('title','asc');
         $query=$this->db->get('address');
       return $query->result();
    }
    
    public function get_child_address2($parent_id)
    {
        $this->db->where('parent_id',$parent_id);
        $this->db->order_by('title','asc');
         $query=$this->db->get('address');
       return $query->result();
    }

    public function getresturent()
    {
    	$query=$this->db->get('restauratsn');
    	return $query->result_array();
    }

    public function addaddresses($data)
    {

        $parent_id = $data['parent_id'];
       
       $this->db->select_max('addr_id');
       $this->db->from("address");
       $this->db->where("parent_id",$parent_id);
       $result = $this->db->get()->result_array();
               
       $this->db->insert('address',$data);

       echo   $result[0]['addr_id'];
    }
    public function delete_address($addr_id)
    {
        
            $query="DELETE FROM `address` WHERE `address`.`addr_id` = $addr_id";
           
           $this->db->query($query); 
       //$this->db->where('addr_id',$addr_id);
       //$this->db->delete('address');    
       //echo  $addr_id;
    }

    public function getmenuitem($id)
    {
       $query= $this->db->where('res_id',$id)->get('food_menu');
       return $query->result();
    }
    
    public function getmenuname($menuid)
    {
        $query=$this->db->where('fm_id',$menuid)->get('food_menu');
        $result= $query->result_array();
        return $result[0]['food_name'];
    }
    // insertion of single cart item in itemcart table
    public function insert_item_in_cart_m($data){
      return $this->db->insert('itemcart',$data);
    }
    
    public function getresturentname($resturentid)
    {
       $query= $this->db->select('*')->where('res_id',$resturentid)->get('restauratsn');
       $result= $query->result_array();
       return $result[0]['res_name'];
    }
    public function insert_order($input_order)
    {
      $this->db->insert('order',$input_order);
    }

   public function insert_customer($input_customer)
     {

      $query = $this->db->query(
        "SELECT * FROM customer WHERE cellno 
        =".$this->db->escape($input_customer["cellno"])." limit 1");
      if($query->num_rows() == 0 ){
          $this->db->insert('customer', $input_customer);
          return $this->db->insert_id();
        }
        else{
            $result = $query->result_array();
            return $result[0]['customer_id'];
        }

      // $this->db->insert('customer',$input_customer);
 
     }

  public function insert_address($input_address)
   {
    $this->db->insert('order_addresses',$input_address);
   }

   public function add_colddrink($data)
   {
      $this->db->insert('colddrink',$data);
   }

   public function pending_order()
   {
      $this->db->select('*');
      $this->db->from('order');
      $this->db->where('status',1);
      $query=$this->db->get();
      return $query->result();
   }

   public function pending_order_details($o_id)
   {
      $this->db->select('*');
      $this->db->from('customer');
      $this->db->join('order','order.customer_id=customer.customer_id');
      $this->db->join('order_addresses','order.o_id=order_addresses.o_id');
      $this->db->where('order.o_id',$o_id);
      $query=$this->db->get();
      return $query->result();
   }
   
   public function pending_order_restaurants($o_id)
   {
      $this->db->select('*');
      $this->db->from('orders');
      $this->db->join('restauratsn','restauratsn.res_id=order_resturants.r_id');
      $this->db->join('restauratsn','restauratsn.res_id=order_resturants.r_id');
      $this->db->join('food_menu','food_menu.fm_id=order_resturants.menu_id');
      $this->db->where('order.o_id',$o_id);
      $query=$this->db->get();
      return $query->result();
   }
   public function order_colddrinks($o_id)
   {
      $this->db->select('*');
      $this->db->from('colddrink');
      $this->db->join('crud_coldrinks','colddrink.colddrink_name=crud_coldrinks.colddrink_id');
      $this->db->where('colddrink.o_id',$o_id);
      $query=$this->db->get();
      return $query->result();
   }
   
   public function order_food_details($o_id)
   {
      $this->db->select('*');
      $this->db->from('customer');
      $this->db->join('order','order.customer_id=customer.customer_id');
      $this->db->join('order_addresses','order.o_id=order_addresses.o_id');
      $this->db->join('order_resturants','order.o_id=order_resturants.o_id');
      $this->db->join('restauratsn','restauratsn.res_id=order_resturants.r_id');
      $this->db->join('food_menu','food_menu.fm_id=order_resturants.menu_id');
      $this->db->where('order.o_id',$o_id);
      $query=$this->db->get();
      return $query->result();
   }
   public function pending_generalorder_details($o_id)
   {
      $this->db->select('*');
      $this->db->from('customer');
      $this->db->join('order','order.customer_id=customer.customer_id');
      $this->db->where('order.o_id',$o_id);
      $query=$this->db->get();
      return $query->result();
   }
   
   public function generalorder_basic_details($o_id)
   {
      $this->db->select('*');
      $this->db->from('order');
      $this->db->join('order_addresses','order.o_id=order_addresses.o_id');
      $this->db->join('address','address.addr_id=order_addresses.order_address_id');
      $this->db->where('order_addresses.o_id',$o_id);
      $query=$this->db->get();
      return $query->result();
       
   }

   public function pending_update_status($id,$data){
      $this->db->where('o_id',$id);
      $this->db->update('order',$data);
   }
   public function process_order(){
     
    
     $this->db->select('*');
      $this->db->from('order');
      $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
      //$this->db->where('order.ordertype',1);
      $this->db->group_by('order.o_id');
      $this->db->order_by('order.o_id', 'desc');
      $query=$this->db->get();
      return $query->result_array();


   }
   public function ua_order(){
     
    
     $this->db->select('*');
      $this->db->from('order');
      $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
      $this->db->where('order.ordertype',1);
      $this->db->where('order.rider',NULL);
      $this->db->group_by('order.o_id');
      $query=$this->db->get();
      return $query->result_array();


   }
   
   public function ua_gorder()
   {
      // $this->output->enable_profiler(TRUE);
       $this->db->select('*');
      $this->db->from('order');
      $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
     // $this->db->where('order.status',2);
     $this->db->where('order.rider',NULL);
     $this->db->where('order.ordertype',2);
     $this->db->group_by('order.o_id');
      $query=$this->db->get();
      
      $order_details_arr = Array();
      foreach($query->result_array() as $key=>$val){
          $order_details_arr[$key]['od'] = $val;
          
          
                 $this->db->select('from,to,billing,order_address_id');
                  $this->db->from('order');
                  $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
                  //$this->db->where('order.status',2);
                 $this->db->where('order.ordertype',2);
                 $this->db->where('order.o_id',$val['o_id']);
                  $query=$this->db->get()->result_array();
                  foreach($query as $key1=>$val1){
                    $order_details_arr[$key]['otf'][] = array("from"=>$val1['from'],"to"=>$val1['to'],"billing"=>$val1['billing'],"order_address_id"=>$val1['order_address_id']);
                  }
      }
     // echo "<pre>";
      //print_r($order_details_arr);die;
      return $order_details_arr; 
   }
   public function process_gorder($limit, $offset)
   {
       //$this->output->enable_profiler(TRUE);
    date_default_timezone_set('Asia/Karachi');
       $this->db->select('*');
      $this->db->from('order');
      $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
      $this->db->limit($limit, $offset);
     // $this->db->where('order.status',2);
    // $this->db->where('order.ordertype',2);
      $this->db->order_by('order.o_id',"desc");
     $this->db->group_by('order.o_id');
     //$this->db->where('orderdate', date('Y-m-d'));
      $query=$this->db->get();
      
      $order_details_arr = Array();
      foreach($query->result_array() as $key=>$val){
          $order_details_arr[$key]['od'] = $val;
          
          
                 $this->db->select('from,to,billing,order_address_id');
                  $this->db->from('order');
                  $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
                  //$this->db->where('order.status',2);
                 //$this->db->where('order.ordertype',2);
                 $this->db->where('order.o_id',$val['o_id']);
                  $query=$this->db->get()->result_array();
                  foreach($query as $key1=>$val1){
                    $order_details_arr[$key]['otf'][] = array("from"=>$val1['from'],"to"=>$val1['to'],"billing"=>$val1['billing'],"order_address_id"=>$val1['order_address_id']);
                  }
      }
     // echo "<pre>";
      //print_r($order_details_arr);die;
      return $order_details_arr; 
   }
   
     public function get_order_status_array($status){
        date_default_timezone_set('Asia/Karachi');
        $status_time = date("h:i");
        switch ($status) {
            case '2':
                return $data=array(
                'status'=>2,
                'placedtime'=>$status_time
                );
                break;
            case '6':
                return $data=array(
                'status'=>6,
                'rider_acknowleg'=>$status_time
                );
                break;
            case '7':
                return $data=array(
                'status'=>7,
                'riderpicking_time'=>$status_time
                );
                break;
                // case 8 will write the status to 4 i-e complete and the time will to rider_droptime
            case '8':
                return $data=array(
                'status'=>4,
                'rider_droptime'=>$status_time
                );
                break;
             default:
                # code...
                break;
        }
    }
     public function get_order_status($status){
        switch ($status) {
            case '1':
                return "Pending";
                break;
            case '2':
                return "Placed";
                break;
            case '3':
                return "Processed";
                break;
            case '4':
              return "Complete";
              break;
            case '5':
              return "Canceled";
              break;
            case '6':
                return "Ack";
                break;
            case '7':
                return "Picked";
                break;
            case '8':
                return "Droped";
                break;
            case '9':
                return "expectin in 5 minute";
                break;
            default:
                # code...
                break;
        }
     } 
     
     
   
     
     
     public function getresturentrecord($o_id)
     {
         $query=$this->db->where('o_id',$o_id)->get('order_resturants');
         return $query->result();
     }


    // i write this code for getting from address or to address...
     public function another_address_to_or_from($order_address_id){
        $this->db->select('*');
        $this->db->from('address');
        $this->db->where('addr_id',$order_address_id);
        $query=$this->db->get();
        $result1=$query->result_array();
        $parentid= $result1[0]['parent_id'];
        if($parentid==0){
           if($result[0]['custom_addr']!==""){
            return $result[0]['title']."<br />".$result[0]['custom_addr']."<br />";   
           }else{
              return $result[0]['title']; 
           }
            
        }
        else
        {
            $this->db->select('*');
            $this->db->from('address');
            $this->db->where('addr_id',$parentid);
            $query=$this->db->get();
            $result3=$query->result_array();
            $parentid1=$result3[0]['parent_id'];
            if($parentid1==0)
        {
                   if($result3[0]['custom_addr']!==""){
                     return $result3[0]['title']."<br /> ".$result[0]['title']."<br />".$result[0]['custom_addr']."";
                   }else{
                       return $result3[0]['title']." ".$result[0]['title'];
                   }
        }
              else{
            $this->db->select('*');
            $this->db->from('address');
            $this->db->where('addr_id',$parentid1);
            $query=$this->db->get();
            $result4=$query->result_array();
            $parentid2=$result4[0]['parent_id'];
            if($parentid2==0){
                 return $result4[0]['title']."<br /> ".$result3[0]['title']." ".$result['0']['title']."<br />".$result[0]['custom_addr']."";
            }
            else
            {
                        $this->db->select('*');
                        $this->db->from('address');
                        $this->db->where('addr_id',$parentid2);
                        $query=$this->db->get();
                        $result5=$query->result_array();
                        return $result5[0]['title']."<br />".$result4[0]['title']." ".$result3[0]['title']." ".$result[0]['title']."<br />".$result[0]['custom_addr']."<br />";
            }
           
        }
        }
      }


//this code is used for getting complete order address by id means complete address--------------------------


     public function get_order_address($o_id){
      //my code
      $this->db->select ('*'); 
      $this->db->from ('order_addresses');
      $this->db->join('address','address.addr_id=order_addresses.order_address_id');
      $this->db->where ('o_id', $o_id);
      $query = $this->db->get ();
      $result = $query->result_array();
     //  var_dump($result);
     // exit("get_order_address() in modal");
    // return $result[0]['title']."(".$result[0]['custom_addr'].")";
     $childid=$result[0]['addr_id'];
     $this->db->select('*');
     $this->db->from('address');
     $this->db->where('addr_id',$childid);
     $query=$this->db->get();
     $result1=$query->result_array();
     $parentid= $result1[0]['parent_id'];
     if($parentid==0){
        if($result[0]['custom_addr']!==""){
         return $result[0]['title']."<br />".$result[0]['custom_addr']."<br />";   
        }else{
           return $result[0]['title']; 
        }
         
     }
     else
     {
         $this->db->select('*');
         $this->db->from('address');
         $this->db->where('addr_id',$parentid);
         $query=$this->db->get();
         $result3=$query->result_array();
         $parentid1=$result3[0]['parent_id'];
         if($parentid1==0)
     {
                if($result3[0]['custom_addr']!==""){
                  return $result3[0]['title']."<br /> ".$result[0]['title']."<br />".$result[0]['custom_addr']."";
                }else{
                    return $result3[0]['title']." ".$result[0]['title'];
                }
     }
           else{
         $this->db->select('*');
         $this->db->from('address');
         $this->db->where('addr_id',$parentid1);
         $query=$this->db->get();
         $result4=$query->result_array();
         $parentid2=$result4[0]['parent_id'];
         if($parentid2==0){
              return $result4[0]['title']."<br /> ".$result3[0]['title']." ".$result['0']['title']."<br />".$result[0]['custom_addr']."";
         }
         else
         {
                     $this->db->select('*');
                     $this->db->from('address');
                     $this->db->where('addr_id',$parentid2);
                     $query=$this->db->get();
                     $result5=$query->result_array();
                     return $result5[0]['title']."<br />".$result4[0]['title']." ".$result3[0]['title']." ".$result[0]['title']."<br />".$result[0]['custom_addr']."<br />";
         }
        
     }
     }
     //------------------------------------End--------------------------------------
    
      

     }  
     public function get_order_from_address($o_id){

     $from  = 1;
     $this->db->select('*');
     $this->db->from('order_addresses');
     $this->db->join('address','order_addresses.order_address_id=address.addr_id');
     $this->db->where('order_addresses.o_id',$o_id);
     $this->db->where('order_addresses.from',$from);
     $query=$this->db->get();
     $result=$query->result_array();
     $childid = $result[0]['title']."(".$result[0]['custom_addr'].")";
     $childid=$result[0]['addr_id'];
     $this->db->select('*');
     $this->db->from('address');
     $this->db->where('addr_id',$childid);
     $query=$this->db->get();
     $result1=$query->result_array();
     $parentid= $result1[0]['parent_id'];
     if($parentid==0){
         return $result[0]['title']."(".$result[0]['custom_addr'].")";
     }
     else
     {
         $this->db->select('*');
         $this->db->from('address');
         $this->db->where('addr_id',$parentid);
         $query=$this->db->get();
         $result3=$query->result_array();
         $parentid1=$result3[0]['parent_id'];
         if($parentid1==0)
     {
         return $result3[0]['title']." ".$result[0]['title']."(".$result[0]['custom_addr'].")";
     }
           else{
         $this->db->select('*');
         $this->db->from('address');
         $this->db->where('addr_id',$parentid1);
         $query=$this->db->get();
         $result4=$query->result_array();
         $parentid2=$result4[0]['parent_id'];
         if($parentid2==0){
              return $result4[0]['title']." ".$result3[0]['title']." ".$result['0']['title']."(".$result[0]['custom_addr'].")";
         }
         else
         {
                     $this->db->select('*');
                     $this->db->from('address');
                     $this->db->where('addr_id',$parentid2);
                     $query=$this->db->get();
                     $result5=$query->result_array();
                     return $result5[0]['title']." ".$result4[0]['title']." ".$result3[0]['title']." ".$result[0]['title']."(".$result[0]['custom_addr'].")";
         }
        
     }
     }
     //------------------------------------End--------------------------------------
    
      

     }  

     public function get_absolute_addr($childid){
     $from  = 1;
     
     $this->db->select('*');
     $this->db->from('address');
     $this->db->where('addr_id',$childid);
     $query=$this->db->get();
     $result1=$query->result_array();
     $parentid= $result1[0]['parent_id'];
     
     if($parentid==0){
         return $result1[0]['title'];
     }
     else
     {
         $this->db->select('*');
         $this->db->from('address');
         $this->db->where('addr_id',$parentid);
         $query=$this->db->get();
         $result3=$query->result_array();
         $parentid1=$result3[0]['parent_id'];
         if($parentid1==0)
     {
         return $result3[0]['title']." ".$result1[0]['title'];
     }
           else{
         $this->db->select('*');
         $this->db->from('address');
         $this->db->where('addr_id',$parentid1);
         $query=$this->db->get();
         $result4=$query->result_array();
         $parentid2=$result4[0]['parent_id'];
         if($parentid2==0){
              return $result4[0]['title']." ".$result3[0]['title']." ".$result1['0']['title'];
         }
         else
         {
                     $this->db->select('*');
                     $this->db->from('address');
                     $this->db->where('addr_id',$parentid2);
                     $query=$this->db->get();
                     $result5=$query->result_array();
                     return $result5[0]['title']." ".$result4[0]['title']." ".$result3[0]['title']." ".$result1[0]['title'];
         }
        
     }
     }
     //------------------------------------End--------------------------------------
    
      

     }       
     //this get general  addresss 
     public function getgeneraltoaddress($o_id)
     {
         $this->db->select('order_address_id');
         $this->db->from('order_addresses');
         $this->db->where('o_id',$o_id);
         $this->db->where('to',1);
         $this->db->where('from',0);
         $query=$this->db->get();
          $result= $query->result_array();
          $addresses = "";
         foreach($result as $needle=>$haystack){
             
                 $child_id = $result[$needle]['order_address_id'];
                 $this->db->select('title');
                 $this->db->from('address');
                 $this->db->where('addr_id',$child_id);
                 $query=$this->db->get();
                 $result1=$query->result_array();
                 
             $addresses.=$result1[0]['title']." , ";
         };
        $addresses = rtrim($addresses,",");
        return $addresses;
    
     }
     
         public function getaddress($addressid)
         {
             $this->db->select('*');
             $this->db->from('address');
             $this->db->where('addr_id',$addressid);
             $query=$this->db->get();
             $result=$query->result_array();
            //return $result[0]['title'];
              $childid=$result[0]['addr_id'];
             $this->db->select('*');
             $this->db->from('address');
             $this->db->where('addr_id',$childid);
             $query=$this->db->get();
             $result1=$query->result_array();
             $parentid= $result1[0]['parent_id'];
             if($parentid==0){
             return $result[0]['title'];
             }
              else
              {
                 $this->db->select('*');
                 $this->db->from('address');
                 $this->db->where('addr_id',$parentid);
                 $query=$this->db->get();
                 $result3=$query->result_array();
                 $parentid1=$result3[0]['parent_id'];
                 
                     if($parentid1==0)
                     {
                         return $result3[0]['title']." ".$result[0]['title'];
                     }
                      else{
                         $this->db->select('*');
                         $this->db->from('address');
                         $this->db->where('addr_id',$parentid1);
                         $query=$this->db->get();
                         $result4=$query->result_array();
                         $parentid2=$result4[0]['parent_id'];
                         if($parentid2==0){
                       return $result4[0]['title']." ".$result3[0]['title']." ".$result['0']['title'];
                         }
                         
                         else
                             {
                                         $this->db->select('*');
                                         $this->db->from('address');
                                         $this->db->where('addr_id',$parentid2);
                                         $query=$this->db->get();
                                         $result5=$query->result_array();
                                         return $result5[0]['title']." ".$result4[0]['title']." ".$result3[0]['title']." ".$result[0]['title'];
                             }
                        }
                 
        
                 
              }
           
               
                            
                             
                
                              
                
         }
         
     
     public function get_customer_address($o_id){
      $sql = "SELECT a.title,oa.custom_addr FROM `order_addresses` oa inner join address a on oa.order_address_id = a.addr_id where o_id = ".$o_id;
      $rs = $this->db->query($sql);
      $res = $rs->result_array();
      return $res[0]['title']."(".$res[0]['custom_addr'].")";

     }   



     public function ger_order_resturentid($o_id){
      $this->db->select("*");
      $this->db->from('order_resturants');
      $this->db->join('order','order.o_id=order_resturants.o_id');
      $this->db->where('order_resturants.o_id',$o_id);
      $this->db->group_by('order_resturants.r_id');
      $query=$this->db->get();
      $result=$query->result_array();
      return $result[0]['r_id'];
     }
      

      public function get_resturent_name($restid){
        $this->db->select('res_name');
        $this->db->from('restauratsn');
        $this->db->where('res_id',$restid);
        $query=$this->db->get();
        $result=$query->result_array();
        return $result[0]['res_name'];
        
        
      }
  

      public function process_order_details($o_id)
   {
      // $this->db->select('*');
      // $this->db->from('order');
      // $this->db->join('customer','order.customer_id=customer.customer_id');
      // $this->db->join('order_addresses','order.o_id=order_addresses.o_id');
      // $this->db->join('order_resturants','order.o_id=order_resturants.o_id');
      // $this->db->join('restauratsn','restauratsn.res_id=order_resturants.r_id'); this is not implemented
      // $this->db->join('food_menu','food_menu.fm_id=order_resturants.menu_id');
      // $this->db->where('order.o_id',$o_id);
      // $this->db->where('status',2);
      // $query=$this->db->get();
      // return $query->result();  i commented this code...

      // i write this code...
    $this->db->select ( '*' ); 
    $this->db->from ( 'order' );
    $this->db->join ('customer', 'customer.customer_id = order.customer_id');
    // $this->db->join ('order_addresses', 'order_addresses.o_id = order.o_id');
    // $this->db->join ('order_resturants', 'order_resturants.o_id = order.o_id');
    $this->db->where ( 'order.o_id', $o_id);
    $query = $this->db->get ();
    return $query->result ();

   }
   // below funtion will be hook in process_order_detail in controller method for getting address
   public function order_addresses($o_id){
      $this->db->select ( '*' ); 
      $this->db->from ( 'order_addresses' );
      $this->db->where ( 'o_id', $o_id);
      $query = $this->db->get ();
      return $query->result ();
   }

   public function order_food($o_id){
      $this->db->select ( '*' ); 
      $this->db->from ( 'order_resturants' );
      $this->db->join ('restauratsn', 'restauratsn.res_id = order_resturants.r_id');
      $this->db->where ( 'order_resturants.o_id', $o_id);
      $query = $this->db->get ();
      return $query->result ();
   }

   public function get_food_items_list_by_ids($array_values){
      
      $this->db->select( '*' ); 
      $this->db->from( 'food_menu' );
      $this->db->join ('restauratsn', 'restauratsn.res_id = food_menu.res_id');
      $this->db->where_in( 'fm_id', $array_values);
      $query = $this->db->get();
      return $query->result();

      // same query but shorter...
      $query =  $this->db->
                where_in( 'fm_id', $array_values)->
                get('food_menu');
      return $query->result();
   }

   public function rider_info($rider_id){

    $query = $this->db->where('r_id',$rider_id)->get('riders');
    return $query->result();
   }






   public function process_order_basic_details($o_id)
   {
      $this->db->select('*');
      $this->db->from('customer');
      $this->db->join('order','order.customer_id=customer.customer_id');
      $this->db->join('order_addresses','order.o_id=order_addresses.o_id');
      $this->db->join('order_resturants','order.o_id=order_resturants.o_id');
      $this->db->join('restauratsn','restauratsn.res_id=order_resturants.r_id');
      $this->db->join('food_menu','food_menu.fm_id=order_resturants.menu_id');
      $this->db->where('order.o_id',$o_id);
      $this->db->where('status',2);
      $this->db->group_by('order.o_id');
      $query=$this->db->get();
      return $query->result();
   }







//canel order updattion ------------------------------
    public function cancelorder($cancelid,$data)
    {
      $this->db->where('o_id',$cancelid);
      $this->db->update('order',$data);
    }

// this code is for change the status of order...
    public function changeStatus_m($order_id,$data){
      
      $this->db->where('o_id',$order_id);
      $this->db->update('order',$data);
    }


//-------------------End------------------





//this code is for getting the rider dynamically in third account when right click then show popup and riderlist show in that popup----------------------
    public function selectrider(){
      $query=$this->db->where('status', 0)->where('Active', 1)->get('riders');
      return $query->result();
    }
//-----------------------------------End-----------------------------------





//Assing riders and update the record in order table also update riders table by changing the status and address to rider---------------------------------
    public function assignriders($inputrider,$oid){
      
      $updaterider=array(
          'status'=>1,
          'last_delivery'=>$inputrider['address']
         );
      $this->db->where('r_id', $inputrider['rider']);
      $this->db->update('riders', $updaterider);
      unset($inputrider['address']);
      $this->db->where('o_id',$oid);
      $this->db->update('order',$inputrider);

    }

//------------------------------------------End-----------------------------------------





//be defualt riderassing null when no rider assingn if rider assing then return its name  ----------------------------------
    public function getrider($id)
    {
      if($id==0){
        return"not assign";
      }
      else
      {
     $this->db->select('name');
     $this->db->from('riders');
     $this->db->where('r_id',$id);
     $query=$this->db->get();
     $result= $query->result_array();
     return $result[0]['name'];
     }
    }
//----------------------------------End----------------------------------------






//getting customer record by cellno using on blure method------------------------------
   public function getcustomer($cellno){
    $this->db->select('*');
    $this->db->from('order');
    $this->db->join('order_addresses','order.o_id=order_addresses.o_id');
    $this->db->join('address','order_addresses.order_address_id=address.addr_id');
    $this->db->join('customer','customer.customer_id=order.customer_id');
    $this->db->where('cellno',$cellno);
    $this->db->order_by('order.ordertime',"desc");
    
    $this->db->group_by('order.o_id');
    $this->db->limit('1');
    $query=$this->db->get();
    $row = $query->row();
    return $row;
    //return $row;
   }
   //--------------------------------------END---------------------------------------------
   
   
   
   
   
   
   //-----------------------------------------------------------------------------------------
    public function getcustomer1($gcellno){
    $this->db->select('*');
    $this->db->from('order');
    $this->db->join('order_addresses','order.o_id=order_addresses.o_id');
    $this->db->join('address','order_addresses.order_address_id=address.addr_id');
    $this->db->join('customer','customer.customer_id=order.customer_id');
    $this->db->where('cellno',$gcellno);
    $this->db->order_by('order.o_id',"desc");
    $this->db->limit(1);
    $query=$this->db->get();
    return $query->row();
   }
   //---------------------------------------------------------------------------------------
   
   
   

  /* public function getitemprices($id)
   {
       $query=$this->db->where('fm_id',$id)->get('food_menu');
     
       return $query->result_array();
   }*/


  public function get_order_by_id($o_id){
      $this->db->select('*');
      $this->db->from('order');
      // $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
      // $this->db->group_by('order.o_id');
      // $this->db->order_by('order.o_id','desc');
      $this->db->where('o_id',$o_id);
      $query=$this->db->get();
      return $query->result_array();
 
  }



//get all order and show all orderes
  public function getallorder(){
      $this->db->select('*');
      $this->db->from('order');
      $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
      $this->db->group_by('order.o_id');
      $this->db->order_by('order.o_id','desc');
      //$this->db->where('ordertype',1);
      $query=$this->db->get();
      return $query->result_array();
 
  }
        // my code for mobiles order both
  // below function simply select all general order and show it on general order form for now...
  public function mob_general_order(){
    $query = $this->db->select('*')->get('mob_general_order');
    return $result = $query->result();
  }

  public function food_items($id){
    $query = $this->db->where('mo_id', $id)->join('food_menu','mob_fr_items.fm_id=food_menu.fm_id')
    ->join('restauratsn','restauratsn.res_id=food_menu.res_id')
    ->get('mob_fr_items');
    return $result = $query->result();
  }

  // below function simply select all food order and show it on food order form for now...
  public function mob_food_order(){
    // joining must be implemented here...
    $query = $this->db->distinct()->select('*')->from('mob_food_order')
    ->join('mob_fr_items','mob_fr_items.mo_id=mob_food_order.mo_id')
    ->join('food_menu','mob_fr_items.fm_id=food_menu.fm_id')->group_by('mob_food_order.mo_id')
          ->get();
    // $query = $this->db->query("SELECT mob_food_order.mo_id,mob_food_order.mo_time,mob_food_order.mo_name,mob_food_order.mo_cellno,mob_food_order.mo_address,restauratsn.res_name,food_menu.food_name,mob_fr_items.f_quantity FROM `mob_food_order`,`mob_fr_items`,`food_menu`,`restauratsn` WHERE mob_food_order.mo_id = mob_fr_items.mo_id AND mob_fr_items.fm_id = food_menu.fm_id AND food_menu.res_id=restauratsn.res_id");
    return $result = $query->result();
  }
// this method will recieve id and table name and make action accordingly & i used this in two ajax method.
  public function delete_mob_m($id, $tablename){
    $this->db->where('mo_id',$id);
    $this->db->delete($tablename);
  }

  // search method for searching order according to creteria...
  public function search_m($from, $to){

    $this->db->where('ordertime >=', $from);
    $this->db->where('ordertime <=', $to);
    $this->db->order_by('order.o_id', 'desc');
    $query = $this->db->get('order');
    return $query->result_array();
  }
  
  public function getallgenralorder()
  {
      $this->db->select('*');
      $this->db->from('order');
      $this->db->where('order.ordertype',2);
      $query = $this->db->get();
      return $query->result_array();
  }
  
  public function getgenraladdress($order_id)
  {
      $this->db->select('*');
      $this->db->from('order_addresses');
      $this->db->where('o_id',$order_id);
       $query=$this->db->get();
      return $query->result_array();
  }


 /* public function deleteorder($id){
    $this->db->where('o_id',$id);
    $this->db->delte('order');
  }*/
    
    
//food order form editting record for editting--------------------------------------------------------------------------
    public function editorderformrecord($id){
      $this->db->select("*");
      $this->db->from('order');
      $this->db->join('customer','order.customer_id=order.customer_id');
      $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
      $this->db->join('order_resturants','order_resturants.o_id=order.o_id');
      $this->db->where('order.o_id',$id);
      $this->db->group_by('order.o_id',$id);
      $query=$this->db->get();
       return $result=$query->result_array();
      
    }
    
    public function itemrecord($id)
    {
        $this->db->select('*');
        $this->db->from('order_resturants');
        $this->db->where('o_id',$id);
        $query=$this->db->get();
        return $result=$query->result_array();
        
    }
    //end of food editting record ---------------------------------------------------------------------------------------
    
   
   //edit generalformorder code to get data for editting-----------------------------------------------------
   public function editgeneralorderformrecord($id)
   {
      $this->db->select("*");
      $this->db->from('order');
      $this->db->join('customer','order.customer_id=order.customer_id');
      $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
      $this->db->where('order.o_id',$id);
      $this->db->group_by('order.o_id',$id);
      $query=$this->db->get();
       return $result=$query->result_array();
       
   }
   
   //getting addresses from order_addresses table for generalform editting---------------
   public function getgeneraladdresses($id)
   {
       $this->db->select('*');
       $this->db->from('order_addresses');
       $this->db->where('o_id',$id);
       $query=$this->db->get();
       return $result=$query->result_array();
   }
//end of generalorderform editting gettting data--------------------------------------------------------------------






    public function getitemprice($id)
    {
      $this->db->where('fm_id',$id);
      $query=$this->db->get('food_menu');
     return $query->row();
    }
     
     
     
     
     
     
    //code for getting all candel order for some reason---------------------------------------------------
    public function all_cancel_order()
    {
      $this->db->select('*');
      $this->db->from('order');
      $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
      $this->db->where('order.status',5);
      $query=$this->db->get();
      return $query->result_array();
    }
    
    //end of cancel order query-------------------------------------------





//code for getting all completed order by rider------------------------------------------------------------------

    public function all_complete_order()
    {
      $this->db->select('*');
      $this->db->from('order');
      $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
      $this->db->where('order.status',4);
      $this->db->order_by('order.o_id', 'desc');
      $query=$this->db->get();
      return $query->result_array();
    }
    //end of completeorder query---------------------------------------------------------------------------







//this code for gettting data with cellno like fromaddress toaddress and customer name as well as contact no  for sending sms---------------just for food order
    public function getcellno($id)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->join('order','order.customer_id=customer.customer_id');
        $this->db->join('order_addresses','order_addresses.o_id=order.o_id');
        $this->db->join('order_resturants','order_resturants.o_id=order.o_id');
        $this->db->where('order.o_id',$id);
        $query1=$this->db->get();
        $result3=$query1->row();
        $result1= $query1->result_array();
      //return $result1;
        $addressid=$result1[0]['order_address_id'];
        $resturentid=$result1[0]['r_id'];
        //return $addressid;
        $this->db->select('*');
        $this->db->from('address');
        $this->db->where('addr_id',$addressid);
        $query2=$this->db->get();
        $result2= $query2->row();


        $this->db->select('*');
        $this->db->from('restauratsn');
        $this->db->where('res_id',$resturentid);
        $query3=$this->db->get();
        $result4=$query3->row();
        $result5=$this->ordertracker_m->get_order_address($id);
        echo json_encode(array($result3,$result2,$result4,$result5));exit;
    }

//end of getting data--------------------------------------------------------------------

         


//get cold drinks for displaying in order form dynamically----------------------------------------------
    public function get_colddrink()
    {
       $this->db->select('*');
       $this->db->from('crud_coldrinks');
       $query=$this->db->get();
       if($query->num_rows()>0)
       {
          return $query->result();
       }
       else
       {
          return FALSE;
       }
    }
//--------------------------------------END-------------------------------------------------



    
    
    //get colddrinks by id while editting colddrinks-------------------------------------------
    public function getedit_colddrinks($o_id)
    {
        $query=$this->db->where('o_id',$o_id)->get('colddrink');
        return $query->result_array();
    }
//-----------------------------------End--------------------------------------------




        public function get_pricetime()
    {
       $this->db->select('*');
       $this->db->from('crud_timeprice');
       $this->db->order_by('time_price_id');
       $query=$this->db->get();
       if($query->num_rows()>0)
       {
          return $query->result();
       }
       else
       {
          return FALSE;
       }
    }
    

    
    
}