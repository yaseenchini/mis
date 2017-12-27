<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class all_orders extends Admin_Controller{
    
    public function __construct()
    {
        
        parent::__construct();
        $this->output->enable_profiler(false);              
    }
    
    
    public function index()
    {
        $this->view();
    }
    
    
    /**
     * get a list of all users
     */
    public function view()
    {    
        $this->output->enable_profiler(TRUE);
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');

        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['allorder']=$this->ordertracker_m->getallorder();
        
        $this->data['title'] = "All Order";
        $this->data['view'] = "ordertracker/allorder";
        $this->load->view("layout", $this->data);
      
    }
    
    public function all_genralorder()
    {
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');

        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['allgenralorder']=$this->ordertracker_m->getallgenralorder();
        
        $this->data['title'] = "All Genral Order";
        $this->data['view'] = "ordertracker/all_genralorder";
        $this->load->view("layout", $this->data);
    }
    //---------- save items in session and then show on modal for saving in cart item
    public function save_food_items(){

        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');
        
        $id=$this->input->post('qty');
        $item=$this->input->post('itemid');
        $itemname=$this->input->post('itemname');
        $resturentid=$this->input->post('resturentid');
        
        for($i=0;$i<count($item);$i++)
        {
            $insertitem=array(
                'itemname'=>$itemname[$i],
                'itemid'=>$item[$i],
                'qty'=>$id[$i],
                'restid'=>$resturentid[$i]
                
                );
                $this->db->insert('itemcart',$insertitem);
        }
       
          

        
    }
    //End of Saving item in session ------------


    //load order form and insert order form to a datatabase--------------
    public function add_order()
    {
                //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');
        
        
        //validation
         $valid_config = array(
            array(
                'field' =>  'cellno',
                'rules' =>  'trim|required'
            ),
            array(
                'field' => 'c_name',
                'rules' => 'trim|required'
            ),
            array(
                'field' =>  'comment',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE) 
        {  
            $alreadyplacedtime=$this->input->post('placetime');
            if(empty($alreadyplacedtime)){
             
            $input_customer = array(
                'cellno'       =>  $this->input->post('cellno'),
                'cust_name'    =>  $this->input->post('c_name'),
                'comment'      =>  $this->input->post('comment'),
            );
             $this->ordertracker_m->insert_customer($input_customer);
             $cid = $this->db->insert_id();



            $customprice=$this->input->post('customprice');
            $price=$this->input->post('price');
            $radiotime=$this->input->post('time');
            $customtime=$this->input->post('deliverytime');
            
            $d_price = $customprice;
            if(!empty($price)){
                $d_price = $price;
            }

            $d_time = $customtime;
            if(!empty($radiotime)){
                $d_time = $radiotime;
            }
            date_default_timezone_set('Asia/Karachi');
            $input_order=array(
            'order_details'=>$this->input->post('orrderdetails'),
            'delivery_charges'=>$d_price,
            'deliverytime'=>$d_time,
            'customer_id'=>$cid,
            'ordertime' =>date("Y-m-d h:i:s"),
            'ordertype'=>1
            );
            $this->ordertracker_m->insert_order($input_order);
            $li_id = $this->db->insert_id();
  
                  
            if(isset($_POST['itemid'])){
               $count=count($_POST['itemid']);
                 for($i=0; $i<$count; $i++) {
                  
                    $query="INSERT into order_resturants (r_id,menu_id,qty,o_id) VALUES('".$_POST['restid'][$i]."','".$_POST['itemid'][$i]."','".$_POST['qty'][$i]."',".$li_id.")";
                    $this->db->query($query);
                }

                $this->db->truncate('itemcart');

            }

                
                $cold=$this->input->post('cold');
                if(isset($_POST['cold'])){
                    
                $count=count($this->input->post('cold'));
                for($i=0;$i<$count; $i++)
                {
                   
                    $data=array(
                        'colddrink_name'=>$_POST['cold'][$i],
                        //'liter'=>$this->input->post('liter'),
                        'o_id'=>$li_id
                        );
                    $this->ordertracker_m->add_colddrink($data);
                } 
                
                
                }
                  
                


                $addressid=$this->input->post('addressid');
                 if(!empty($addressid)){
                      $input_address=array(
                'order_address_id' => $addressid,
                'custom_addr' => $this->input->post('customaddress'),
                'o_id'=>$li_id
                );
                 }
                 else{
                 $input_address=array(
                'order_address_id' => $this->input->post('address1_selection'),
                'custom_addr' => $this->input->post('customaddress'),
                'o_id'=>$li_id
                );
                 }
              
           
            $this->ordertracker_m->insert_address($input_address);
             if($input_customer>0)
             {
                $this->session->set_flashdata("msg_success", "New user created successfully");
                redirect("order/add_order");
            }
            else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("order/add_order");
            }
           }
           else
           {

            $input_customer = array(
                'cellno'       =>  $this->input->post('cellno'),
                'cust_name'    =>  $this->input->post('c_name'),
                'comment'      =>  $this->input->post('comment')  
            );
             $this->ordertracker_m->insert_customer($input_customer);
             $cid = $this->db->insert_id();



            $customprice=$this->input->post('customprice');
            $price=$this->input->post('price');
            $radiotime=$this->input->post('time');
            $customtime=$this->input->post('deliverytime');
            
            $d_price = $customprice;
            if(!empty($price)){
                $d_price = $price;
            }

            $d_time = $customtime;
            if(!empty($radiotime)){
                $d_time = $radiotime;
            }
            date_default_timezone_set('Asia/Karachi');

             $placedtime=date("Y-m-d h:i:s");
             $input_order=array(
            'order_details'=>$this->input->post('orrderdetails'),
            'delivery_charges'=>$d_price,
            'deliverytime'=>$d_time,
            'customer_id'=>$cid,
            'orderreadytime'=>$this->input->post('placetime'),
            'status'=>2,
            'placedtime'=>$placedtime
            );
            $this->ordertracker_m->insert_order($input_order);
            $li_id = $this->db->insert_id();
  
                  
          
               $count=count($_POST['itemid']);
                 for($i=0; $i<$count; $i++) {
                  
               $query="INSERT into order_resturants (r_id,menu_id,qty,o_id) VALUES('".$_POST['restid'][$i]."','".$_POST['itemid'][$i]."','".$_POST['qty'][$i]."',".$li_id.")";
                $this->db->query($query);
                }

                $this->db->truncate('itemcart');

                $addressid=$this->input->post('addressid');
                 if(!empty($addressid)){
                      $input_address=array(
                'order_address_id' => $addressid,
                'custom_addr' => $this->input->post('customaddress'),
                'o_id'=>$li_id
                );
                 }
                 else{
                 $input_address=array(
                'order_address_id' => $this->input->post('checked_modules'),
                'custom_addr' => $this->input->post('customaddress'),
                'o_id'=>$li_id
                );
                 }
              
           
            $this->ordertracker_m->insert_address($input_address);
             if($input_customer>0)
             {
                $this->session->set_flashdata("msg_success", "New user created successfully");
                redirect("order/add_order");
            }
            else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("order/add_order");
            }
  







           }
        }
        
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['address']=$this->ordertracker_m->address();
        $this->data['resturent']=$this->ordertracker_m->getresturent();
        $this->data['colddrink']=$this->ordertracker_m->get_colddrink();
        $this->data['pricetime']=$this->ordertracker_m->get_pricetime();
        $this->data['title'] = "Order";
        $this->data['view'] = "ordertracker/orderform";
        $this->load->view("layout", $this->data);
    }

    //End of insertion of Order Form----------------
    
         public function ua_orders(){
        
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');

        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
       // echo "<pre>";
        //print_r($this->ordertracker_m->process_order());die;
        $this->data['processorder']=$this->ordertracker_m->ua_order();
        $this->data['gprocessorder']=$this->ordertracker_m->ua_gorder();
        $this->data['rider']=$this->ordertracker_m->selectrider();
        
        $this->data['title'] = "All process order";
        $this->data['view'] = "riderassignment/processorder";
        $this->load->view("layout", $this->data);
     } 
     public function generate_addresses()
    {
 
        $this->load->model('ordertracker_m'); 

        echo "<ul>";
            foreach ($this->ordertracker_m->address() as $value){
               echo "<li id=".$value->addr_id.">";
               echo $value->title;
               
                    echo "<ul>";
                    foreach($this->ordertracker_m->get_child_address($value->addr_id) as $child)
                    {
                        echo "<li id=".$child->addr_id.">";
                        echo $child->title;
                          echo"<ul>";
                          foreach($this->ordertracker_m->get_child_address($child->addr_id) as $child1)
                          {
                              echo "<li id=".$child1->addr_id.">";
                              echo $child1->title;
                                echo "<ul>";
                                foreach($this->ordertracker_m->get_child_address($child1->addr_id) as $child2)
                                {
                                    echo "<li id=".$child2->addr_id.">";
                                    echo $child2->title;
                                }
                                echo "</ul>";
                                echo "</li>";
                          }
                          echo "</ul>";
                          echo "</li>";
                    }
                
                    echo "</ul>";
                    
                    echo "</li>";
               
            }
      
        echo "</ul>";   
                  
                          
    }
     public function add_genral_order()
    {
 
        //loading models
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');         
        
        //validation
        $gvalid_config = array(
            array(
                'field' =>  'gcellno',
                'rules' =>  'trim|required'
            ),
            array(
                'field' => 'gc_name',
                'rules' => 'trim|required'
            ),
            array(
                'field' =>  'gcomment',
                'rules' =>  'trim|required'
            )
        );
        
        $this->form_validation->set_rules($gvalid_config);
        //check rules
        if($this->form_validation->run() === TRUE) 
        {  
           $galreadyplacedtime=$this->input->post('gplacetime');
                //adding the cutomer to the list 
                $ginput_customer = array(
                    'cellno'       =>  $this->input->post('gcellno'),
                    'cust_name'    =>  $this->input->post('gc_name'),
                    'comment'      =>  $this->input->post('gcomment')  
                );
                $this->ordertracker_m->insert_customer($ginput_customer);
                $gcid = $this->db->insert_id();
             
                $gcustomprice=$this->input->post('gcustomprice');
                $gprice=$this->input->post('gprice');
                $gradiotime=$this->input->post('gtime');
                $gcustomtime=$this->input->post('gdeliverytime');         

                $gd_price = $gcustomprice;
                if(!empty($gprice)){
                    $gd_price = $gprice;
                }
                $gd_time = $gcustomtime;
                if(!empty($gradiotime)){
                    $gd_time = $gradiotime;
                }
                date_default_timezone_set('Asia/Karachi');
                if(isset($galreadyplacedtime)){
                    $gplacedtime=date("Y-m-d h:i:s");
                     $ginput_order=array(
                    'order_details'=>$this->input->post('gorrderdetails'),
                    'delivery_charges'=>$gd_price,
                    'deliverytime'=>$gd_time,
                    'customer_id'=>$gcid,
                    'orderreadytime'=>$this->input->post('gplacetime'),
                    'status'=>2,
                    'placedtime'=>$gplacedtime,
                    'ordertype'=>2,
                    'ordertime'=>date("Y-m-d h:i:s")
                    );                
                }else{
                    $ginput_order=array(
                        'order_details'=>$this->input->post('gorrderdetails'),
                        'delivery_charges'=>$gd_price,
                        'deliverytime'=>$gd_time,
                        'customer_id'=>$gcid,
                        'ordertime'=>date("Y-m-d h:i:s"),
                        'ordertype'=>2,
                    );                    
                }

                $this->ordertracker_m->insert_order($ginput_order);
                $gli_id = $this->db->insert_id();    
            
                $gaddressid=$this->input->post('gaddressid');

                    $count=count($this->input->post('gchecked_modules'));
                    $from = json_decode(stripslashes($_POST['from']));
                    $to = json_decode(stripslashes($_POST['to']));
                    $billing = json_decode(stripslashes($_POST['billing']));

                      for($i=0;$i<$count;$i++)
                      {
                          //this code is not working i have written script in generalorderform at the end please check it---------------------
                          /*  $from = $from[$i];
                            if($from[$i]==""){
                                $from = 0;
                            }
                            
                            $to = $to[$i];
                            if($to[$i]==""){
                                $to = 0;
                            }*/

                            $custom_addr_arr = $this->input->post('gcustomaddress');
                           //same this one is too------------------
                            if($billing[$i]==NULL){
                                $billing_addr = 0;
                            }else{
                                $billing_addr = $billing[$i];
                            }
                            if($from[$i]==NULL){
                                $from_addr = 0;
                            }else{
                                $from_addr = $from[$i];
                            }
                            if($to[$i]==NULL){
                                $to_addr = 0;
                            }else{
                                $to_addr = $to[$i];
                            }
                                      
                            if(!empty($gaddressid)){

                                 $ginput_address=array(
                                'order_address_id' => $gaddressid,
                                'custom_addr' => $custom_addr_arr[$i],
                                'o_id'=>$gli_id,
                                'from'=> $from_addr,
                                'to'=> $to_addr,
                                'billing' =>$billing_addr,
                                'number' => $this->input->post('gaddcellno'),
                                'nameopt'=>$this->input->post('gaddc_name'),
                                'commentopt'=>$this->input->post('gaddcomment'),
                                );
                             }else{
                                 $ginput_address=array(
                                    'order_address_id' =>$_POST['gchecked_modules'][$i],
                                    'custom_addr' => $_POST['gcustomaddress'][$i],
                                    'from'=> $from_addr,
                                    'to'=> $to_addr,
                                    'billing' =>$billing_addr,
                                    'number' => $this->input->post('gaddcellno'),
                                    'nameopt'=>$this->input->post('gaddc_name'),
                                    'commentopt'=>$this->input->post('gaddcomment'),
                                    'o_id'=>$gli_id
                                );                                
                             }
         
                            $this->ordertracker_m->insert_address($ginput_address);
                             
                            
                      }
                     
                 
                 
             if($ginput_customer>0)
             {
                $this->session->set_flashdata("msg_success", "Order Added Successfully ");
                //redirect("order/add_genral_order");
             }
            else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                //redirect("order/add_genral_order");
            }
           
           
            
        }
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['address']=$this->ordertracker_m->address();
        $this->data['title'] = " General Order";
        $this->data['view'] = "ordertracker/generalorder";
        $this->load->view("layout", $this->data);
    }





    //end of general order form insertion ----------------------------------


    public function edit_order($o_id)
    {
        
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');
        
      
        
        //validation
         $valid_config = array(
            array(
                'field' =>  'cellno',
                'rules' =>  'trim|required'
            ),
            array(
                'field' => 'c_name',
                'rules' => 'trim|required'
            ),
            array(
                'field' =>  'comment',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE) 
        {  
            $alreadyplacedtime=$this->input->post('placetime');
            if(empty($alreadyplacedtime)){
             $orderid=$this->input->post('orderid');
             $customer_id=$this->input->post('customerid');
            $update_customer = array(
                'cellno'       =>  $this->input->post('cellno'),
                'cust_name'    =>  $this->input->post('c_name'),
                'comment'      =>  $this->input->post('comment'),
            );
             $this->db->where('customer_id',$customer_id)->update('customer',$update_customer);
             $cid = $this->db->insert_id();



            $customprice=$this->input->post('customprice');
            $price=$this->input->post('price');
            $radiotime=$this->input->post('time');
            $customtime=$this->input->post('deliverytime');
            
            $d_price = $customprice;
            if(!empty($price)){
                $d_price = $price;
            }

            $d_time = $customtime;
            if(!empty($radiotime)){
                $d_time = $radiotime;
            }
            date_default_timezone_set('Asia/Karachi');
            $update_order=array(
            'order_details'=>$this->input->post('orrderdetails'),
            'delivery_charges'=>$d_price,
            'deliverytime'=>$d_time,

            );
            $this->db->where('o_id',$orderid)->update('order',$update_order);
        
               if(!empty($_POST['itemid'])){
               $count=count($_POST['itemid']);
                 for($i=0; $i<$count; $i++) {
                  
               $query="INSERT into order_resturants (r_id,menu_id,qty,o_id) VALUES('".$_POST['restid'][$i]."','".$_POST['itemid'][$i]."','".$_POST['qty'][$i]."',".$orderid.")";
                $this->db->query($query);
                }
               }
               
                $this->db->truncate('itemcart');




                $cold=$this->input->post('cold');
                if(isset($cold)){
                $count=count($this->input->post('cold')); 
                 
                for($i=0;$i<$count; $i++)
                {
                   
                    $update_colddrinks=array(
                        'colddrink_name'=>$_POST['cold'][$i],
                        'liter'=>$this->input->post('liter')
                        );
                    $this->db->where('o_id',$orderid)->update('colddrink',$update_colddrinks);
                } 
                
                }
                  



             
                 $update_address=array(
                'order_address_id' => $this->input->post('checked_modules'),
                'custom_addr' => $this->input->post('customaddress')
                );
                 
              
           
            $this->db->where('o_id',$orderid)->update('order_addresses',$update_address);
             if($update_address>0)
             {
                $this->session->set_flashdata("msg_success", "New user created successfully");
                redirect("order/edit_order");
            }
            else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("order/edit_order");
            }
           }
           else
           {
             $orderid=$this->input->post('orderid');
             $customer_id=$this->input->post('customerid');
             $update_customer = array(
                'cellno'       =>  $this->input->post('cellno'),
                'cust_name'    =>  $this->input->post('c_name'),
                'comment'      =>  $this->input->post('comment')  
            );
             $this->db->where('customer_id',$customer_id)->update('customer',$update_customer);



            $customprice=$this->input->post('customprice');
            $price=$this->input->post('price');
            $radiotime=$this->input->post('time');
            $customtime=$this->input->post('deliverytime');
            
            $d_price = $customprice;
            if(!empty($price)){
                $d_price = $price;
            }

            $d_time = $customtime;
            if(!empty($radiotime)){
                $d_time = $radiotime;
            }
            date_default_timezone_set('Asia/Karachi');

             //$placedtime=date("Y-m-d h:i:s");
             $update_order=array(
            'order_details'=>$this->input->post('orrderdetails'),
            'delivery_charges'=>$d_price,
            'deliverytime'=>$d_time,
            'orderreadytime'=>$this->input->post('placetime')
            );
            $this->db->where('o_id',$orderid)->update('order',$update_order);
  
                  
              if(!empty($_POST['itemid'])){
               $count=count($_POST['itemid']);
                 for($i=0; $i<$count; $i++) {
                  
               $query="INSERT into order_resturants (r_id,menu_id,qty,o_id) VALUES('".$_POST['restid'][$i]."','".$_POST['itemid'][$i]."','".$_POST['qty'][$i]."',".$orderid.")";
                $this->db->query($query);
                }
              }
                $this->db->truncate('itemcart');

           
                 $update_address=array(
                'order_address_id' => $this->input->post('checked_modules'),
                'custom_addr' => $this->input->post('customaddress'),
                );
                 
              
           
            $this->db->where('o_id',$orderid)->update('order_addresses',$update_address);
             if($update_address>0)
             {
                $this->session->set_flashdata("msg_success", "New user created successfully");
                redirect("order/edit_order");
            }
            else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("order/edit_order");
            }
  

           }
        }
      
        
        
        
        $this->load->model('ordertracker_m');
        $this->load->model('role_m');
        $this->load->model('department_m');
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['editorderformrecord']=$this->ordertracker_m->editorderformrecord($o_id);
        $this->data['itemrecord']=$this->ordertracker_m->itemrecord($o_id);
        $this->data['address']=$this->ordertracker_m->address();
        $this->data['resturent']=$this->ordertracker_m->getresturent();
        $this->data['colddrink']=$this->ordertracker_m->get_colddrink();
        $this->data['pricetime']=$this->ordertracker_m->get_pricetime();
        $this->data['editcolddrink']=$this->ordertracker_m->getedit_colddrinks($o_id);
        $this->data['title'] = " Edit Food Order";
        $this->data['view'] = "ordertracker/edit_orderform";
        $this->load->view("layout", $this->data);
        

    }
    
    public function edit_generalorder($o_id)
    {
        $this->load->model('ordertracker_m');
        $this->load->model('role_m');
        $this->load->model('department_m');
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['editgeneralorderformrecord']=$this->ordertracker_m->editgeneralorderformrecord($o_id);
        $this->data['generaladdresses']=$this->ordertracker_m->getgeneraladdresses($o_id);
        $this->data['address']=$this->ordertracker_m->address();
        $this->data['title'] = " Edit General Order";
        $this->data['view'] = "ordertracker/edit_generalform";
        $this->load->view("layout", $this->data);
    }
    
    
    public function deleteorder($order_id)
    {
        $query="DELETE FROM `order` WHERE `order`.`o_id` = $order_id";
           
           $this->db->query($query);
           redirect('order/view');
    }

    
    //insertion address id and address name through Ajax-----------   
     public function list_addresses(){
   
         $data=array(
            'title'=> $this->input->post('addressname'),
            'parent_id'=> $this->input->post('max')
            );
         $this->load->model('ordertracker_m');
         $this->ordertracker_m->addaddresses($data);
     }

     //End  of address inserton through Ajax-------------


     //get menu item and show on modal----------
  
     public function getmenu(){
         $this->load->model("role_m");
        $this->load->model('department_m');
         $this->load->model('ordertracker_m');
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $id=$this->input->post('id');
        $data=$this->ordertracker_m->getmenuitem($id); 
       if(count($data>0)){
        $modal='';
        $modal.='<div class="modal-dialog" id="ordermodal"><div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="row">
           <div class="col-md-6">
             <h4 class="modal-title" style="color:black">Select Item</h4>
             </div>
             <div class="col-md-6">
             <input type="text" name="search" id="search" placeholder="search"/>
             <input type="hidden" name="restid" id="restid" value='.$id.'/>
             </div>
             </div>
        </div>
        <div class="modal-body"><br>
         <div class="row"><div class="col-md-4"><ul id="mymenu">';
        foreach($data as $value){
             $modal.='<li value="'.$value->fm_id.'" id="getitemvalue" style="cursor:pointer">'.$value->food_name.'</li><input type="hidden" name="restid" id="restid" value='.$id.'>';
        }

            $modal.='</ul></div><div class="col-md-8"><form name="item-form" id="item-form" method="post">
            <table id="appenditem"></table></form></div>
        </div> ';
        $modal.='<div class="modal-footer" id="footer">
        <label class="text text-success">Total</label>&nbsp;&nbsp;<input type="text" name="" id="total" value="0.0" disabled style="margin-right:200px;width:100px;text-align:center"/>
        <button type="button" class="btn btn-primary" id="saveitem">Save</button></div>
        </div></div>';
        echo $modal;
       }
       
     }
    //End of menu item -------------------
    
       //All pending orders ------------------------------------------------


     public function pending_order(){
        
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['pendingorder']=$this->ordertracker_m->pending_order();
        $this->data['title'] = "All Unplaced Orders";
        $this->data['view'] = "orderplacer/all_pending_order";
        $this->load->view("layout", $this->data);
          
     }
     //---------------------------------


     //pending order details ------------------------------------

     public function pending_order_details($o_id)
     {
        $this->output->enable_profiler(TRUE);
        $o_id = (int) $o_id;
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['basic_details']=$this->ordertracker_m->pending_order_details($o_id);
        $this->data['food_details']=$this->ordertracker_m->order_food_details($o_id);
        $this->data['cold_drinks']=$this->ordertracker_m->order_colddrinks($o_id);
        $this->data['title'] = "Unplaced Order Details";
        $this->data['view'] = "orderplacer/pending_order_details";
        $this->load->view("layout", $this->data);  
     }
     //------------------------------------------------------
     
     
     public function pending_generalorder_details($o_id)
     {
        $this->output->enable_profiler(TRUE);
        $o_id = (int) $o_id;
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['basic_details']=$this->ordertracker_m->pending_generalorder_details($o_id);
     
        $this->data['generalorder_basic_details']=$this->ordertracker_m->generalorder_basic_details($o_id);
        $this->data['title'] = "General Order Details";
        $this->data['view'] = "orderplacer/pending_generalorder_details";
        $this->load->view("layout", $this->data);  
     }


     //here i process the order and change the status of order to 2------------
     
     
     public function generalorder_process($o_id)
     {
          
         date_default_timezone_set('Asia/Karachi');
         $placedtime=date("Y-m-d h:i:s");
         $data=array(
            'comment'=>$this->input->post('gcomment'),
            'status'=>2,
            'orderreadytime'=>$this->input->post('greadytime'),
            'placedtime'=> $placedtime
            );
         $this->db->where('o_id',$o_id)->update('order',$data); 
         redirect('order/pending_order');
     }

     public function order_process($orderid){
        //$this->output->enable_profiler(TRUE);
         $this->load->model('ordertracker_m');
         date_default_timezone_set('Asia/Karachi');
         $placedtime=date("Y-m-d h:i:s");
         $data=array(
            'comment'=>$this->input->post('comment'),
            'status'=>2,
            'orderreadytime'=>$this->input->post('readytime'),
            'placedtime'=> $placedtime
            );

         $this->ordertracker_m->pending_update_status($orderid,$data);
         redirect('order/pending_order');
     }
     //--------------------end-------------------------
     

     //All process order

     public function process_order(){
        
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');

        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
       // echo "<pre>";
        //print_r($this->ordertracker_m->process_order());die;
        $this->data['processorder']=$this->ordertracker_m->process_order();
        $this->data['gprocessorder']=$this->ordertracker_m->process_gorder();
        $this->data['rider']=$this->ordertracker_m->selectrider();
        
        $this->data['title'] = "All process order";
        $this->data['view'] = "riderassignment/processorder";
        $this->load->view("layout", $this->data);
     } 
   


      public function process_order_details($o_id){
        $o_id = (int) $o_id;
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['processorderdetail']=$this->ordertracker_m->process_order_details($o_id);
        $this->data['pending_order_restaurants']=$this->ordertracker_m->pending_order_restaurants($o_id);
        $this->data['order_colddrinks']=$this->ordertracker_m->order_colddrinks($o_id);
        $this->data['process_order_basic_details']=$this->ordertracker_m->process_order_basic_details($o_id);
        $this->data['selectrider']=$this->ordertracker_m->selectrider();
        $this->data['title'] = "Process Order Details";
        $this->data['view'] = "riderassignment/process_order_details";
        $this->load->view("layout", $this->data); 
      }


      //-------------------------------------------------------rider assign as will as send sms to rider for picking ther order---------
      public function rider_assign(){
        $this->load->model('ordertracker_m');
        $this->load->model("role_m");
        $rider=$this->input->post('rider');
        $id=$this->input->post('oid');
        $cellno=$this->input->post('cellno');
        $to=$this->input->post('to');
        $from=$this->input->post('from');
        $custname=$this->input->post('customername');
        $ridercellno=$this->input->post('ridercellno');
        $message="order no is ".$id." please pick  order  from  ".$from." to ".$to." customer name is " . $custname. " and  cell no  is " . $cellno . " thank you";
         $inputrider=array(
             'status'=>3,
             'rider'=>$rider
            );
        $this->ordertracker_m->assignriders($inputrider,$id);
       // $this->sendsms($cellno,$message);
        $this->load->helper('my_functions_helper');
        sendsms($ridercellno,$message);
        redirect('order/process_order');
      }
      
      
      //-----------------------------END---------------------
      
      
      

//get customer deatials by jquery ajax when user enter mobile no 
      public function getcustomerrecord(){
           $this->output->enable_profiler(false);
           $cellno=$this->input->post('cellno');
           $this->load->model('ordertracker_m');
           $data = $this->ordertracker_m->getcustomer($cellno);
           $comment  = $data->comment;
           $order_address_id  = $data->order_address_id;
           $cust_name  = $data->cust_name;

           $title  = $this->ordertracker_m->get_absolute_addr($order_address_id);
           $array_data = Array("title"=>$title,"cust_name"=>$cust_name,"comment"=>$comment,"order_address_id"=>$data->order_address_id);
           //print_r($this->ordertracker_m->getcustomer($cellno));
           //$data=$this->ordertracker_m->getcustomer($cellno);
            echo json_encode($array_data);
            
                   
      }
      
      public function get_absolute_addr(){
           $this->load->model('ordertracker_m');
           //$this->output->enable_profiler(false);
          $addr_id = $this->input->post('addr_id');
          echo $this->ordertracker_m->get_absolute_addr($addr_id);
            
                   
      }
      
      
        //------------------------
       public function generalcustomerrecord(){
           $this->output->enable_profiler(false);
           $gcellno=$this->input->post('gcellno');
           $this->load->model('ordertracker_m');
           $data=$this->ordertracker_m->getcustomer1($gcellno);
            echo json_encode($data);exit;
          
      }



//getting data from itemcard that have saved and display in orderform for inserting----------------
      public function saveitems(){
          $this->load->model('ordertracker_m');
           $this->output->enable_profiler(false);

        $query=$this->db->get('itemcart');
          $result=$query->result();
          foreach ($result as $value) {
              $li='';
            $li.='<tr id="'.$value->restid.'"><td>';
          $li.='<li  style="list-style-type:none;color:green">'.$value->itemname.' &nbsp;&nbsp;<span class="badge">'.$this->ordertracker_m->getresturentname($value->restid).'</span> &nbsp;&nbsp;<span class="badge">'.$value->qty.'</span></li>
          <input type="hidden" name="qty[]" value="'.$value->qty.'"/><input type="hidden" name="itemid[]" value='.$value->itemid.'/><input type="hidden" name="restid[]" value='.$value->restid.'/>';
           $li.='<button type="button" value="'.$value->itemid.'" class="btn btn-danger btn-xs" id="deletecartitem">X</button></td></tr>';
          echo $li;
          
          }
          
        

      }
      
     //---------------------------------End----------------------------------
     
     
     
     
     
     
     
      //delete cartitem when click on cancel or cross button ------------
      public function deletecartitem()
      {
          $itemid=$this->input->post('itemid');
          $this->db->where('itemid',$itemid)->delete('itemcart');
      }
//-----------------------------------------------------


//get price of item to show in modal menu---------------------------
      public function getprice(){
       $itemid=$this->input->post('id');
       $this->load->model('ordertracker_m');
       $data=$this->ordertracker_m->getitemprice($itemid);
       echo json_encode($data);exit;

      }
//-----------------End-------------






      public function cancelorder()
      {
        $canelid=$this->input->post('id');
        $cancelreason=$this->input->post('reason');
        $this->load->model('ordertracker_m');
        $data=array(
             'status'=>5,
             'reason'=>$cancelreason
            );
        $this->ordertracker_m->cancelorder($canelid,$data);
      }
   
   
   
   

      public function all_cancel_order()
      {
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['cancelorder']=$this->ordertracker_m->all_cancel_order();
        $this->data['title'] = "All Cancel order";
        $this->data['view'] = "ordertracker/all_cancel_order";
        $this->load->view("layout", $this->data);

      }




      public function order_complete()
      {
                                       
                    
                    
       $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['completeorder']=$this->ordertracker_m->all_complete_order();
        $this->data['title'] = "All Completed Order";
        $this->data['view'] = "ordertracker/order_complete";
        $this->load->view("layout",$this->data);
      }




      public function getcellno()
      {
           $id=$this->input->post('id');
           $this->load->model('ordertracker_m');
           $this->ordertracker_m->getcellno($id);
          

      }
      
      public function getgcellno()
      { 
         
           
           $id=$this->input->post('id');
           $this->db->select('*');
           $this->db->from('customer');
           $this->db->join('order','order.customer_id=customer.customer_id');
           $this->db->where('order.o_id',$id);
           $query=$this->db->get();
           $result=$query->row();
           echo json_encode($result);exit;
      }





//-------------------------------------------------
//sms sending api and code------------------------------------------
   function get_session()
{
   $username="68"; #Put your API Username here
   $password="dw@123"; #Put your API Password here
    
   $data=file_get_contents("http://api.smilesn.com/session?username=".$username."&password=".$password);
   $data=json_decode($data);
   $sessionid=$data->sessionid;

   $file2 = fopen('session.txt', 'w');

   $file1 = fopen('session.txt', 'a');
   fputs($file1, $sessionid);
   fclose($file1);

   return $sessionid;
}
    
public function sendsms($mobile_number,$message){      
         
         $session_id =$this->get_session();
         $username = '68';
         $password = 'dw@123';


        echo  $url = "http://api.smilesn.com/sendsms?sid=".$session_id."&receivenum=".$mobile_number."&textmessage=".urlencode($message);exit;
        $ch  =  curl_init();
        $timeout  =  1;
        $url = str_replace(" ", '%20', $url);
        curl_setopt ($ch,CURLOPT_URL, $url) ;
        curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
        $response = curl_exec($ch);
        curl_close($ch) ; 
        return true;
}

//end of sms Api and code----------------------------------------------------------
//-------------------------------------------------------------------------------------------------------

  //function for receiving sms through customer------------------------
         public function receive_sms()
       {
            
            
            
             $sql = "INSERT INTO `received_sms` (sender, receive_text) VALUES (".$_GET['sender'].",'".$_GET['fulltext']."')";
             $this->db->query($sql);
             $smstext=explode(" ",$_GET['fulltext']);
             $orderno=$smstext[1];
             $ack=$smstext[2];
                 if($ack === 'a')
                 {
                     date_default_timezone_set('Asia/Karachi');
                      $acktime=date("Y-m-d h:i:s");
                      $updateack=array(
                     'rider_acknowleg'=>$ack,
                     'rider_acktime'=>$acktime,
                     'status'=>6
                 
                     );
                     $this->db->where('o_id',$orderno)->update('order',$updateack);
                     echo"obaid";exit;
                 }elseif($ack === 'p')
                 {
                    date_default_timezone_set('Asia/Karachi');
                      $picktime=date("Y-m-d h:i:s");
                         $updatepick=array(
                             'rider_acknowleg'=>$ack,
                             'riderpicking_time'=>$picktime,
                             'status'=>7
                 
                 );
                  
                  $this->db->where('o_id',$orderno)->update('order',$updatepick);
                  echo "izhar";exit;
                     
                 }elseif($ack === 'd')
                 {
                     date_default_timezone_set('Asia/Karachi');
                      $droptime=date("Y-m-d h:i:s");
                         $updatedrop=array(
                             'rider_acknowleg'=>$ack,
                             'rider_droptime'=>$droptime,
                             'status'=>8
                             );
                              $this->db->where('o_id',$orderno)->update('order',$updatedrop);
                              
                             echo"tanx for order dropping";exit;
                 }elseif($ack=== '5l')
                 {
                     $this->db->select('cellno');
                     $this->db->from('customer');
                     $this->db->join('order','order.customer_id = customer.customer_id');
                     $this->db->where('order.o_id',$orderno);
                    $query= $this->db->get();
                    $data=$query->result_array();
                    $no=$data[0]['cellno'];
                    
                    
                           $this->load->helper('my_functions_helper');
                           $message="your order will be expected in 5 minutes";
                          sendsms($no,$message);
                          echo"tanx for your message";
                    
                 }
                 elseif($ack==='10l')
                 {
                     $this->db->select('cellno');
                     $this->db->from('customer');
                     $this->db->join('order','order.customer_id = customer.customer_id');
                     $this->db->where('order.o_id',$orderno);
                    $query= $this->db->get();
                    $data=$query->result_array();
                    $no=$data[0]['cellno'];
                    
                    
                           $this->load->helper('my_functions_helper');
                           $message="your order will be expected in 10 minutes";
                          sendsms($no,$message);
                          echo"tanx for your message";
                 }
                 elseif($ack === '5ml')
                 {
                            /*   $this->db->select('*');
                               $this->db->from('order');
                              $this->db->where('o_id',$orderno);
                              $query=$this->db->get();
                              $result=$query->result_array();
                             $date=$result[0]['ordertime'];
                             $currentDate = strtotime($date);
                             $futureDate = $currentDate+(60*5);
                        $formatDate = date("Y-m-d H:i:s", $futureDate);
                        $updatereadytime=array(
                                'ordertime' => $formateDate
                            
                                  );
                                  
                                  $this->db->where('o_id',$orderno)->update('order',$updatereadytime);
                                  echo"tanx for your information";*/
                                  
                                       $this->db->select('*');
                                       $this->db->from('order');
                                       $this->db->where('o_id',$orderno);
                                       $query=$this->db->get();
                                       $result=$query->result_array();
                                       $date=$result[0]['orderreadytime'];
                                       $readytime=$date+5;
                                       $updatereadytime=array(
                                            'orderreadytime' => $readytime
                                        
                                              );
                                  
                                                  $this->db->where('o_id',$orderno)->update('order',$updatereadytime);
                                                  echo"tanx for your information";exit;
                 }
                 
                 
                 elseif($ack==='break')
                 {
                              $updateriderstauts=array(
                                  'admin_approval'=>0
                                  
                                  );
                              $this->db->where('r_id',$orderno)->update('riders',$updateriderstauts);
                             echo"tanx for your response";exit;
                 }
                 
                 
               
                    else
                    { 
                      echo"tanx for your response";exit;
                    }
                 
             
            
       }

       public function apicall()
       {
        $result = file_get_contents("https://businessline.mobilink.com.pk/BusinesslineAPI/?menu=get_call_details&password=SBwyBtZ2ns&masterno=3000341381");
        echo $result;exit;
       }
      
    public function getridercontactno()
    {
        $riderid=$this->input->post('riderid');
        $query=$this->db->where('r_id',$riderid)->get('riders');
        $result=$query->row();
        echo json_encode($result);exit;
    }

// delete item from order_resturants table when editing orderform-------------------------------
     public function itemdeletion()
     {
         $itemid=$this->input->post('id');
         $orderid=$this->input->post('orderid');
         $this->db->where('menu_id',$itemid)->where('o_id',$orderid)->delete('order_resturants');
        
     }

  

 }
