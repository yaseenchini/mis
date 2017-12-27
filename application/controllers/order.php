<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Admin_Controller{
    
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
    public function view(){

        // $this->output->enable_profiler(TRUE); this will display loading time & other meta data collected during execution of script...
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
    // commenting reasion i mentioned there in view below #saveitem
    // public function save_food_items(){

    //     $this->load->model("role_m");
    //     $this->load->model('department_m');
    //     $this->load->model('ordertracker_m');
        
    //     $id=$this->input->post('qty');
    //     $item=$this->input->post('itemid');
    //     $itemname=$this->input->post('itemname');
    //     $resturentid=$this->input->post('resturentid');
        
    //     for($i=0;$i<count($item);$i++)
    //     {
    //         $insertitem=array(
    //             'itemname'=>$itemname[$i],
    //             'itemid'=>$item[$i],
    //             'qty'=>$id[$i],
    //             'restid'=>$resturentid[$i]
                
    //             );
    //             $result = $this->db->insert('itemcart',$insertitem);
    //             echo $result;
    //     }
       
          

        
    // }
    //End of Saving item in session ------------

    //my code this will delete order from food or general order through Ajax methodF
    public function delete_mob(){
        $id        = $this->input->post('id');
        $tablename = $this->input->post('tablename');
        $this->load->model('ordertracker_m'); 
        echo $this->ordertracker_m->delete_mob_m($id, $tablename);
        if($tablename == 'mob_food_order'){
            echo $this->ordertracker_m->delete_mob_m($id, 'mob_fr_items');
        }
    }
    //my code this will update data into cart table on blur Ajax method
    public function cart_update(){
        $food_id = $this->input->post('food_id');
        $qty = array('qty' => $this->input->post('qty'));
        $this->db->where('itemid', $food_id);
        $this->db->update('itemcart', $qty );
        
    }
    // this method is used for real time update the event will be created for this using andriod post method...
    public function food_order(){
        $this->load->model('ordertracker_m');

        $last = $this->db->order_by('mo_id',"desc")
                ->limit(1)
                ->get('mob_food_order')
                ->row();
        $o_id = $last->o_id;
        //print_r($last);
        // $myObj->name = "John";
        // $myObj->age = 30;
        // $myObj->city = "New York";
        $outp = "[";
        foreach($values = $this->ordertracker_m->mob_food_order() as $values){
            $o_id = $values->mo_id;
        if ($outp != "[") {$outp .= ",";}
        $data = $this->ordertracker_m->food_items($o_id);
        //var_dump($data);
        $items= '';
        $resturent = '';
        if($data){
            $items;
            $resturent;
            foreach ($data as $key => $value1) {
                $name = $value1->food_name;
                $quantity =  $value1->f_quantity;
                $items .= $name.":".$quantity.", ";
                $resturent = $value1->res_name;
                }
            }else{
                $items = null;
                $resturent = null;
            }
        $items = rtrim($items, " ,");

        $outp .= '{"items":"'  . $items . '",';
        $outp .= '"resturent":"' . $resturent . '",';
        $outp .= '"mo_id":"' . $values->mo_id . '",';
        $outp .= '"mo_time":"' . $values->mo_time . '",';
        $outp .= '"mo_name":"' . $values->mo_name . '",';
        $outp .= '"mo_cellno":"' . $values->mo_cellno . '",';
        $outp .= '"another":"' . $outp2 . '",';
        $outp .= '"mo_address":"'. $values->mo_address . '"}';

        // $arr->items = $items;
        // $arr->resturent = $resturent;
        // $arr->mo_id = $last->mo_id;
        // $arr->mo_time = $last->mo_time;
                // $arr->ordertype = ($last->ordertype == 1) ? "Food" : "Genral" ;
        // $arr->mo_name = $last->mo_name;
        // $arr->mo_cellno = $last->mo_cellno;
        // $arr->mo_address = $last->mo_address;
    }
        // echo json_encode($arr);
        $outp .="]";
        echo $outp;
    }

    // this method is used for real time update the event will be created for this using andriod post method...
    public function general_order(){
        $this->load->model('ordertracker_m');

        $last = $this->db->order_by('mo_id',"desc")
                ->limit(1)
                ->get('mob_general_order')
                ->row();
        $arr->mo_id = $last->mo_id;
        $arr->mo_details = $last->mo_details;
        $arr->mo_time = $last->mo_time;
        // $arr->ordertype = ($last->ordertype == 1) ? "Food" : "Genral" ;
        $arr->mo_pick_name = $last->mo_pick_name;
        $arr->mo_pick_cellno = $last->mo_pick_cellno;
        $arr->mo_pick_address = $last->mo_pick_address;
        $arr->mo_drop_name = $last->mo_drop_name;
        $arr->mo_drop_cellno = $last->mo_drop_cellno;
        $arr->mo_drop_address = $last->mo_drop_address;
        $arr->bringme_or_dropit = $last->bringme_or_dropit;
        echo json_encode($last);
    }

    // this below method is for search from to to date used allorder()
    public function search(){
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');

        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['search']=$this->ordertracker_m->search_m($from, $to);
        //var_dump($this->data['search']);
        $this->data['title'] = "Search order";
        $this->data['view'] = "ordertracker/search_v";
        $this->load->view("layout", $this->data);
        // end view
    }

    public function food_order_process(){
        $this->load->model('ordertracker_m');

        $last = $this->db->order_by('o_id',"desc")
                ->limit(1)
                ->get('order')
                ->row();
        $o_id = $last->o_id;
        //print_r($last);
        // $myObj->name = "John";
        // $myObj->age = 30;
        // $myObj->city = "New York";
        if($last->ordertype == 1){
            $address = $this->ordertracker_m->get_order_address($o_id);
            $arr->to = strip_tags($address);
        }else{

        }
        $arr->o_id = $last->o_id;
        $arr->order_details = $last->order_details;
        $arr->ordertype = ($last->ordertype == 1) ? "Food" : "Genral" ;
        $arr->delivery_charges = $last->delivery_charges;
        $arr->deliverytime = $last->deliverytime;
        $arr->customer_id = $last->customer_id;
        $arr->status = $last->status;
        $arr->ordertime = $last->ordertime;
        $arr->placedtime = $last->placedtime;
        $arr->orderreadytime = $last->orderreadytime;
        $arr->rider = ($last->rider== NULL) ? "not assign" : $last->rider;
        $arr->rider_acknowleg = $last->rider_acknowleg;
        // echo json_encode($arr);
        echo json_encode($arr);

    }

    public function response(){
         $arr->orderreadytime = "somedata";
        $arr->rider_acknowleg = "$last->rider_acknowleg";
        echo json_encode($arr);
    }

    //load order form and insert order form to a datatabase--------------
    public function add_order(){
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
                'rules' =>  'trim'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){

            $alreadyplacedtime=$this->input->post('placetime');
            
            $mobile_order=$this->input->post('mobile_order');
            if($mobile_order==1){
                $mobile_order;
            }else{
                $mobile_order = 0;
            }
            if(empty($alreadyplacedtime)){
            // customer insertion process & checking wheather we hava already or not
            $input_customer = array(
                'cellno'       =>  $this->input->post('cellno'),
                'cust_name'    =>  $this->input->post('c_name'),
                'comment'      =>  $this->input->post('comment'),
            );
            // this method will check if the customer if exist returns id if not exists inserts & return id
            $cid = $this->ordertracker_m->insert_customer($input_customer);
            // $cid = $this->db->insert_id();

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
            'orderdate' =>date("Y-m-d"),
            'ordertime' =>date("h:i:s"),
            'ordertype'=>1,
            'mobile_order'=>$mobile_order
            );
            $this->ordertracker_m->insert_order($input_order);
            $li_id = $this->db->insert_id();

            $this->db->where('user_id', $this->session->userdata('user_id'));
            $query = $this->db->get('itemcart');
            $result = $query->result_array();
                foreach ($result as $row) {
                    $row['itemname'];
                    $query="INSERT into order_resturants (r_id,menu_id,qty,o_id) VALUES('".$row['restid']."','".$row['itemid']."','".$row['qty']."',".$li_id.")";
                    $this->db->query($query);
                }
            $this->db->where('user_id', $this->session->userdata('user_id'))->delete('itemcart');
            
            // problem 1
            // if(isset($_POST['itemid'])){
            //    $count=count($_POST['itemid']);
            //      for($i=0; $i<$count; $i++) {
                  
            //         $query="INSERT into order_resturants (r_id,menu_id,qty,o_id) VALUES('".$_POST['restid'][$i]."','".$_POST['itemid'][$i]."','".$_POST['qty'][$i]."',".$li_id.")";
            //         $data .= $this->db->query($query);
            //     }

            //     $this->db->truncate('itemcart');

            // }

            // problem 2
            $cold=$this->input->post('cold');
            if(isset($_POST['cold'])){
                
            $count=count($this->input->post('cold'));
                for($i=0;$i<$count; $i++){
                   
                    $data=array(
                        'colddrink_name'=>$_POST['cold'][$i],
                        //'liter'=>$this->input->post('liter'),
                        'o_id'=>$li_id
                        );
                    $this->ordertracker_m->add_colddrink($data);
                } 
            
            }
                  
                

            //problem 3
            $addressid=$this->input->post('addressid');
            // echo $addressid;
                if(!empty($addressid)){
                    $input_address = array(
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
            
            if($input_customer>0){

                $this->session->set_flashdata("msg_success", "New Order created successfully");
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
            // this code sending array to node ...                 
          
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
            $input_address = array(
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
        $this->data['resturent1']=$this->ordertracker_m->getresturent();
        $this->data['colddrink']=$this->ordertracker_m->get_colddrink();
        $this->data['pricetime']=$this->ordertracker_m->get_pricetime();
        $this->data['mob_food_order'] = $this->ordertracker_m->mob_food_order();
        // echo "order controller...";
        // var_dump($this->data['mob_food_order']);
        // exit;
        $this->data['title'] = "Order";
        $this->data['view'] = "ordertracker/orderform";
        $this->load->view("layout", $this->data);

        $order_to_json = $this->ordertracker_m->get_order_by_id($li_id);
        
        //if($order_to_json){
            ////header("Content-Type:text/json");
          //   $myObj->name = "John";
            // $myObj->age = 30;
            // $myObj->city = "New York";
            // $this->output->set_content_type('application/json'); 
             //$this->output->set_output(json_encode($myObj));
             //echo json_encode(array('success'=>true,'message'=>$order_to_json));
             //$this->output->set_output(json_encode($myObj));
        //}


    }
    public function prepare_jstree_addresses(){
        $this->load->model('ordertracker_m');
        echo $this->ordertracker_m->prepare_jstree_addresses();
    }
    //End of insertion of Order Form----------------
   
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
                'rules' =>  'trim'
            )
        );

        // here is my code for Gettinng and setting mobile order stutus if mobile is equal to 1 else 0
        $mobile_order=$this->input->post('mobile_order');
            if($mobile_order==1){
                $mobile_order;

            }else{
                $mobile_order = 0;
            }
        $this->form_validation->set_rules($gvalid_config);
        //check rules
        if($this->form_validation->run() === TRUE) 
        {  
            $selected_addresses = $this->input->post('address');
            $galreadyplacedtime=$this->input->post('gplacetime');
                //adding the cutomer to the list if not exist, *first customer 
                $ginput_customer = array(
                    'cellno'       =>  $this->input->post('gcellno'),
                    'cust_name'    =>  $this->input->post('gc_name'),
                    'comment'      =>  $this->input->post('gcomment')  
                );

                $gcid = $this->ordertracker_m->insert_customer($ginput_customer);
                //$gcid = $this->db->insert_id();

                $gcustomprice=$this->input->post('gcustomprice');// <--- custom price field value
                $gprice=$this->input->post('gprice'); // <--- radio btn price
                $gradiotime=$this->input->post('gtime'); //<--- radio btn time
                $gcustomtime=$this->input->post('gdeliverytime'); // <--- custom time 
                
                $gd_price = $gcustomprice; // gd_price varible will carry price value
                if(!empty($gprice)){
                    $gd_price = $gprice;
                }
                $gd_time = $gcustomtime;  // gd_time variable will carry time feild value
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
                        'orderdate' =>date("Y-m-d"),
                        'ordertime' =>date("h:i:s"),
                        'placedtime'=>$galreadyplacedtime,
                        'ordertype'=>2,
                        'mobile_order'=>$mobile_order
                    );                
                }else{
                    $ginput_order=array(
                        'order_details'=>$this->input->post('gorrderdetails'),
                        'delivery_charges'=>$gd_price,
                        'deliverytime'=>$gd_time,
                        'customer_id'=>$gcid,
                        'orderdate' =>date("Y-m-d"),
                        'ordertime' =>date("h:i:s"),
                        'ordertype'=>2,
                        'mobile_order'=>$mobile_order
                    );                    
                }

                $this->ordertracker_m->insert_order($ginput_order);
                $gli_id = $this->db->insert_id();    
                $gaddressid=$this->input->post('gaddressid');
                $count=count($this->input->post('gchecked_modules'));
                $from = json_decode(stripslashes($_POST['from']));
                $to = json_decode(stripslashes($_POST['to']));
                $billing = json_decode(stripslashes($_POST['billing']));
                
                for($i=0;$i<$count;$i++){
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
                        if($selected_addresses[$i]== NULL){
                            continue;
                        }          
                        if(!empty($gaddressid)){ //on gaddressid ==false will execute below code

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
                        }else{  //on gaddressid ==true will execute below code...
                            //exit();
                            $ginput_address=array(
                                'order_address_id' =>$selected_addresses[$i],
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
                         
                        // var_dump();
                        // exit('i am here...');
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
        $this->data['mob_general_order']=$this->ordertracker_m->mob_general_order();
        $this->data['title'] = " General Order";
        $this->data['view'] = "ordertracker/generalorder";
        $this->load->view("layout", $this->data);
    }

// this method is used to getting all general record through
    function mobile_general_order(){
       $this->load->model('ordertracker_m');
       $data = $this->ordertracker_m->mob_general_order();
       echo json_encode($data);
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
        return  $this->ordertracker_m->addaddresses($data);
     }
     public function delete_address(){
    

          $addr_id =  $this->input->post('addr_id');
          $this->load->model('ordertracker_m'); 
          echo  $this->ordertracker_m->delete_address($addr_id);
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
        $selected_rest = $this->input->post('selected_rest');
        $data=$this->ordertracker_m->getmenuitem($id); 
       if(count($data>0)){
        $modal='';
        $modal.='
        <div id="ordermodal">
        
            <div class="row">

               <div class="col-md-6">
                 <h4 style="color:black">Select Item</h4>
                </div>

                <div class="col-md-6">
                 <input type="text" name="search" id="search" placeholder="search"/>
                 <input type="hidden" name="restid" id="restid" value='.$id.'/>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-md-8">
                <!-- BOX -->
                <div class="box border primary">
                    <div class="box-title">
                        <h4><i class="fa fa-table"></i> '.$selected_rest .'Menu</h4>
                        <div class="tools hidden-xs">
                            <a href="#box-config" data-toggle="modal" class="config">
                                <i class="fa fa-cog"></i>
                            </a>
                            <a href="javascript:;" class="reload">
                                <i class="fa fa-refresh"></i>
                            </a>
                            <a href="javascript:;" class="collapse">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a href="javascript:;" class="remove">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Food Name</th>
                        <th class="hidden-xs">Discription</th>
                        <th>Price</th>
                        <th class="hidden-xs">Add to cart</th>
                      </tr>
                    </thead>
                    <tbody id="mymenu">';
                        $counter= 1;
                        foreach($data as $value){
                        $modal.='
                            <tr style="cursor:pointer">
                                <td> '.$counter++.'</td>
                                <td id="getitemname">
                                    '.$value->food_name.'
                                </td>
                                <td>
                                    '.$value->desc.'
                                </td>
                                <td id="price">
                                    '.$value->price.'
                                </td>
                                <td> <a class="btn btn-xs" value="'.$value->fm_id.'" id="addtocart">Add to Cart</a></td>
                                <input type="hidden" name="" id="getitemvalue" value="'.$value->fm_id.'" >
                                <input type="hidden" name="restid" id="restid" value='.$id.'>
                            </tr>
                            ';
                        }
                    $modal.='                    
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /BOX -->
            </div>
          <!-- /DATA TABLES -->

            <div class="col-md-4">
                <form name="item-form" id="item-form">
                <table  class="table table-striped table-bordered table-hover table-condensed" >
                    <thead>
                          <tr>
                            <th>Food Name</th>
                            <th>Quantity</th>
                            <th>Sub total</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="appenditem">
                        <tbody>
                </table>
                </form>
                    <br />
                    <label>Total</label><input type="text" name="" id="total" value="0.0" disabled style="width:100px;text-align:center" class="pull-right" /> <br /><br />
                <!--    <button type="button" class="btn btn-primary btn-sm pull-right" id="saveitem">Save</button> -->
            </div>
        </div> ';

        $modal.='
        <script>
            jQuery(document).ready(function() {     
                App.setPage("dynamic_table");  //Set current page
                App.init(); //Initialise plugins and elements
            });
        </script>
        <!-- /JAVASCRIPTS -->
        ';
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
       // $this->output->enable_profiler(TRUE);
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
       // $this->output->enable_profiler(TRUE);
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
            $query = $this->db->get('order');
            $number_of_rows = $query->num_rows();

        // pagination code is executed and dispaly pagination in view
            $this->load->library('pagination');
            $config = [
                'base_url'  =>  base_url('order/process_order'),
                'per_page'  =>  30,
                'total_rows' => $number_of_rows,
                'full_tag_open' =>  '<ul class="pagination pagination-sm">',
                'full_tag_close'  =>    '</ul>',
                'first_tag_open'    =>  '<li>',
                'first_tag_close'  =>   '</li>',
                'last_tag_open' =>  '<li>',
                'last_tag_close'  =>    '</li>',
                'next_tag_open' =>  '<li>',
                'next_tag_close'  =>    '</li>',
                'prev_tag_open' =>  '<li>',
                'prev_tag_close'  =>    '</li>',
                'num_tag_open'  =>  '<li>',
                'num_tag_close'  => '</li>',
                'cur_tag_open'  =>  '<li class="active"><a>',
                'cur_tag_close'  => '</a></li>'
            ];
            $this->pagination->initialize($config);
        
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('ordertracker_m');

        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['gprocessorder']=$this->ordertracker_m->process_gorder($config['per_page'], $this->uri->segment(3,0));
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
        $this->data['order']=$this->ordertracker_m->process_order_details($o_id);
        $rider_id = $this->data['order'][0]->rider; // geting rider id for retrieving rider data
        $status_id = $this->data['order'][0]->status;
        $this->data['status']=$this->ordertracker_m->get_order_status($status_id);
        $this->data['rider'] = $this->ordertracker_m->rider_info($rider_id);
        $this->data['addresses'] = $this->ordertracker_m->order_addresses($o_id);
        $order_address_id = $this->data['addresses'][1]->order_address_id; //addr_id
        $this->data['to_or_from'] = $this->ordertracker_m->another_address_to_or_from($order_address_id);
        // get_order_address() is used for getting address of order... not working now
        $this->data['address'] = $this->ordertracker_m->get_order_address($o_id);
        //$this->data['from'] = $this->ordertracker_m->get_order_from_address($o_id);
        $this->data['food'] = $this->ordertracker_m->order_food($o_id);

            // this code simply create an array of food id's from above model data
            $array_values = "";
            foreach ($this->data['food'] as $key => $value) {
                $array_values .= $value->menu_id.",";
            }
            $array_values = rtrim($array_values,',');
            $array_values = explode(',', $array_values);
            
        $this->data['food_items_list'] = $this->ordertracker_m->get_food_items_list_by_ids($array_values);
        //$this->data['pending_order_restaurants']=$this->ordertracker_m->pending_order_restaurants($o_id);
        // above query contains errors...
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
        $charges=$this->input->post('charges');
        $order_details=$this->input->post('order_details');
        $ridercellno=$this->input->post('ridercellno');
        $from = strip_tags($from);
        $to = strip_tags($to);
        $message="Order No:".$id."\nOrder Details: ".$order_details."\nPick order from:".$from."\nDrop to:".$to."\n" . $custname. "\ncustomer#:" . $cellno . "\nCharges:".$charges;
         $inputrider=array(
             'status'=>3,
             'rider'=>$rider,
             'address'=>$to
            );
        $this->ordertracker_m->assignriders($inputrider,$id);
        
			$username = 'alhamraedu';
			$password = 'khan1234';


            $to = $ridercellno;
            $from = 'SMS Alert';
            $url = "http://Lifetimesms.com/plain?username=".$username."&password=" .$password.
            "&to=" .$to. "&from=" .urlencode($from)."&message=" .urlencode($message)."";
            //Curl Start
            $ch = curl_init();
            $timeout = 30;
            curl_setopt ($ch,CURLOPT_URL, $url) ;
            curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
            $response = curl_exec($ch) ;
            curl_close($ch) ; 
            //Write out the response
        //sendsms($ridercellno,$message);
        redirect('order/process_order');
      }
      
      
      //-----------------------------END---------------------
      
      
      

//get customer deatials by jquery ajax when user enter mobile no 
      public function getcustomerrecord(){
          // $this->output->enable_profiler(false);
           $cellno=$this->input->post('cellno');
           $this->load->model('ordertracker_m');
           $data = $this->ordertracker_m->getcustomer($cellno);
           if(count($data) > 0){
           $comment  = $data->comment;
           $order_address_id  = $data->order_address_id;
           $cust_name  = $data->cust_name;
           $customer_id  = $data->customer_id;
           $o_id  = $data->o_id;

           $title  = $this->ordertracker_m->get_absolute_addr($order_address_id);
           $array_data = Array("title"=>$title, "o_id"=>$o_id, "customer_id"=>$customer_id ,"cust_name"=>$cust_name,"comment"=>$comment,"order_address_id"=>$data->order_address_id);
           //print_r($this->ordertracker_m->getcustomer($cellno));
           //$data=$this->ordertracker_m->getcustomer($cellno);
           }else{
            $data = array();
           }
            echo json_encode($data);
            
                   
      }
      
      public function get_absolute_addr(){
           $this->load->model('ordertracker_m');
           //$this->output->enable_profiler(false);
          $addr_id = $this->input->post('addr_id');
          echo $this->ordertracker_m->get_absolute_addr($addr_id);
            
                   
      }
      
      
        //------------------------
       public function generalcustomerrecord(){
           //$this->output->enable_profiler(false);
           $gcellno=$this->input->post('gcellno');
           $this->load->model('ordertracker_m');
           $data=$this->ordertracker_m->getcustomer1($gcellno);
            echo json_encode($data);exit;
          
      }



//getting data from itemcard that have saved and display in orderform for inserting----------------
      // i commented this code reasion is menthion there #saveitem in jquery method
      // public function saveitems(){
      //     $this->load->model('ordertracker_m');
          // $this->output->enable_profiler(false); this line was pre comment before i comment this code

      //   $query=$this->db->get('itemcart');
      //     $result=$query->result();
      //     foreach ($result as $value) {
      //         $li='';
      //       $li.='<tr id="'.$value->restid.'"><td>';
      //     $li.='<li  style="list-style-type:none;color:green">'.$value->itemname.' &nbsp;&nbsp;<span class="badge">'.$this->ordertracker_m->getresturentname($value->restid).'</span> &nbsp;&nbsp;<span class="badge">'.$value->qty.'</span></li>
      //     <input type="hidden" name="qty[]" value="'.$value->qty.'"/><input type="hidden" name="itemid[]" value='.$value->itemid.'/><input type="hidden" name="restid[]" value='.$value->restid.'/>';
      //      $li.='<button type="button" value="'.$value->itemid.'" class="btn btn-danger btn-xs" id="deletecartitem">X</button></td></tr>';
      //     echo $li;
          
      //     }
          
        

      // }
      
     //---------------------------------End----------------------------------
     
     
     
     
     
     
     
      //delete cartitem when click on cancel or cross button ------------
      // deletecartitem method will recive food_id alias itemid & wil delete it receiving through ajax
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

       $cart_item =array(
            'itemname' => $this->input->post('itemname'),
            'itemid'=>$this->input->post('id'),
            'qty'=> 1,
            'restid'=>$this->input->post('restid'),
            'user_id' =>$this->session->userdata('user_id')
        );
      $this->ordertracker_m->insert_item_in_cart_m($cart_item);

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
      // this method is used for to supply / pass the data & change the status of an order
      public function changeStatus(){

        date_default_timezone_set('Asia/Karachi');
        $status_time = date("h:i:s");
        $this->load->model('ordertracker_m');

        $order_id = $this->input->post('orderId');
        $status_id = $this->input->post('statusId');
        $text = $this->input->post('text');
        $timeValue = $this->input->post('timeValue');
        if(!empty($timeValue)){
            // order ready time
            $time = strtotime($status_time);
            $timeValue1 = "+".$timeValue." minutes";
            $endTime = date("h:i:s", strtotime($timeValue1, $time));

            $time1 = date("H:s:i");
            $time1 = strtotime($time1);
            $timeValue2 = "+".$timeValue." minutes";
            $Timer = date("H:i:s", strtotime($timeValue2));

              $data=array(
                   'status'=>$status_id,
                   'orderreadytime'=> $endTime,
                   'placedtime'=>$status_time,
                   'timer'=>$Timer
                  );
           $this->ordertracker_m->changeStatus_m($order_id,$data);
        }else{
            
            // this below code will change the rider stutus ... not working yet !
             if( $status_id == 8 ){

                $this->db->select('rider');
                $this->db->from('order');
                $this->db->where('o_id',$order_id);
                $query=$this->db->get();
                $result= $query->result_array();
                $rider_id = $result[0]['rider'];
                  $rider_status=array(
                   'status'=> 0
                  );
                $this->db->where('r_id', $rider_id);
                $this->db->update('riders', $rider_status);
            }


            // changes the status and inserting time in corresponding table...
            $array = $this->ordertracker_m->get_order_status_array($status_id);
            $this->ordertracker_m->changeStatus_m($order_id,$array);
            
        } 
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
