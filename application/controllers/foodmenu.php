<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Foodmenu extends Admin_Controller{
    
    public function __construct()
    {
        
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        // $this->output->enable_profiler(TRUE);
        //var_dump($this->session->all_userdata());
        $this->load->model('food_m');
    }

     public function index()
    {
        $this->view();
    }

     public function view()
    {
        
        $this->load->model("role_m");
        $this->load->model('department_m'); 
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['fooditem']=$this->food_m->view();
        $this->data['title'] = "Menus List with Resturent";
        $this->data['view'] = "foodmenu/list_food_items";
        $this->load->view("layout", $this->data);
    }

      public function view_all($res_id)
     {
        $res_id=(int) $res_id;
        $this->load->model("role_m");
        $this->load->model('department_m'); 
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['allfooditems'] = $this->food_m->view_all($res_id);
        // var_dump($this->data['allfooditems']);
        // exit;
        $this->data['title'] = "All Food Items";
        $this->data['view'] = "foodmenu/view_all_fooditems";
        $this->load->view("layout", $this->data);
    
    }

    // my function ... for adding items to specific menu...

    public function add_item_to_menu(){
        echo "hey you called me...";
    }

      public function add_food_items()
    {
                //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        
        //validation
        $valid_config = array(
            array(
                'field' => 'foodname',
                'label' =>  'Food Name',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'desc',
                'label' =>  'Description',
                'rules' =>  'trim'
            ),
            array(
                'field' =>  'resturent',
                'label' =>  'Resturent',
                'rules' =>  'trim|required'
            ),
             array(
                'field' =>  'price',
                'label' =>  'Price',
                'rules' =>  'trim|required'
            ),
              array(
                'field' =>  'weight',
                'label' =>  'Weight',
                'rules' =>  'trim'
            ),
            array(
                'field' =>  'food_category',
                'label' =>  'food category',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            $res_id = $this->input->post("resturent");
            $category_id = $this->input->post('food_category');
            $category_name = $this->input->post('category_name');
            $inputs = array(
                'food_name'       =>  $this->input->post("foodname"),
                'desc'       =>  $this->input->post("desc"),
                'res_id'    =>  $this->input->post("resturent"),
                'price'    =>  $this->input->post("price"),
                'food_type'    =>  $this->input->post("food_category"),
                'quantity'    =>  $this->input->post("weight")
                
            );
            
            if($this->food_m->save($inputs)){
                $this->session->set_flashdata("msg_success", "New Food item added successfully");
                redirect("restaurant/explore_items_of_categories/$res_id/$category_id/$category_name");
            }else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("restaurant/explore_items_of_categories/$res_id/$category_id/$category_name");
            }
        }

        $this->data['res']=$this->food_m->get_restaurant();
        $this->data['food_category']=$this->food_m->get_food_category();
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Add new Fooditem";
        $this->data['view'] = "foodmenu/fooditemform";
        $this->load->view("layout", $this->data);
    }

    public function delete_food_items($fm_id)
    {
        $fm_id=(int) $fm_id;
        $this->food_m->delete_food_items($fm_id);
        $this->session->set_flashdata("msg_success", "food Items has been permanently deleted!"); 
        redirect('foodmenu/view');
    }

     public function update_food_items($fm_id)
       {
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        $fm_id = (int) $fm_id;
        $this->data['edit_food'] = $this->food_m->edit_food_items($fm_id);
            //validation
          $valid_config = array(
            array(
                'field' => 'foodname',
                'label' =>  'Food Name',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'desc',
                'label' =>  'Description',
                'rules' =>  'trim'
            ),
            array(
                'field' =>  'resturent',
                'label' =>  'Resturent',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'price',
                'label' =>  'Price',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'weight',
                'label' =>  'Weight',
                'rules' =>  'trim'
            ),
            array(
                'field' =>  'food_category',
                'label' =>  'food category',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            $res_id    = $this->input->post("resturent");
            $category_id = $this->input->post("food_category");

            $fmm_id=$this->input->post('fm_id');
            $inputs = array(
                'food_name'       =>  $this->input->post("foodname"),
                'desc'       =>  $this->input->post("desc"),
                'res_id'    =>  $this->input->post("resturent"),
                'price'    =>  $this->input->post("price"),
                'food_type'    =>  $this->input->post("food_category"),
                'quantity'    =>  $this->input->post("weight")  
            );

             $this->food_m->update_food_items($fmm_id,$inputs);
            if($inputs>0)
            {
                $this->session->set_flashdata("msg_success", "Food Item updated successfully");
                redirect("restaurant/explore_items_of_categories/".$category_id."/".$res_id);
            }
            else
            {
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("restaurant/explore_items_of_categories/".$category_id."/".$res_id);
            }
        }

        $this->data['res']=$this->food_m->get_restaurant();
        $this->data['food_category']=$this->food_m->get_food_category();
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Update food Item";
        $this->data['view'] = "foodmenu/edit_food_item";
        $this->load->view("layout", $this->data);
    }
// this below code is for category adding & more...
    public function add_food_category(){
        $this->load->model("role_m");
        $this->load->model('department_m');
        $res_name = $this->input->post('res_name');   
        //validation
        $valid_config = array(
            array(
                'field' => 'resturent',
                'label' =>  'Resturent',
                'rules' =>  'trim|required'
            ),
            array(
                'field' => 'food_category',
                'label' =>  'Food Category Name',
                'rules' =>  'trim'
            ),
            array(
                'field' => 'filter_food_category',
                'label' =>  'Food Category Name',
                'rules' =>  'trim'
            )
        );
        $this->form_validation->set_rules($valid_config);
        $category = "";
        if($this->form_validation->run() === TRUE){
            $resturent = $this->input->post('resturent');
            $food_category = $this->input->post("food_category");
            $filter_food_category = $this->input->post("filter_food_category");
            
            if(!empty($filter_food_category)){
                $category = $filter_food_category;
                $inputs = array(
                    'res_id'    => $resturent,
                    'fc_id'     => $filter_food_category
                );
                if($this->food_m->restro_food_category_insert($inputs)){
                    $this->session->set_flashdata("msg_success", "New Category Assigned successfully");
                    redirect("restaurant/explore/$resturent/$res_name");
                }
            }

            if(!empty($food_category)){
                $category = $food_category;
                $input1 = array(
                    'fc_name'    => $food_category
                );
                $id = $this->food_m->save_category($input1);
                    if(empty($id)){
                        $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                        redirect("restaurant/explore/$resturent/$res_name");
                    }
                $inputs = array(
                    'res_id'    => $resturent,
                    'fc_id'     => $id
                );
                if($this->food_m->restro_food_category_insert($inputs)){
                    $this->session->set_flashdata("msg_success", "New Category added and Assigned successfully");
                    redirect("restaurant/explore/$resturent/$res_name");
                }

            }
        }
        $this->load->model('food_m');
        $this->data['res']=$this->food_m->get_restaurant();
        $this->data['food_category']=$this->food_m->get_food_category();
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "All Food Category";
        $this->data['view'] = "foodmenu/food_category_form";
        $this->load->view("layout", $this->data);

    }

     public function update_food_category($fm_id, $res_id)
       {
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');

        $fm_id = (int) $fm_id;
        $res_id = (int) $res_id;
        // echo $fm_id;
        // exit;
        $this->data['edit_food'] = $this->food_m->edit_food_category($fm_id);
            //validation
          $valid_config = array(
            array(
                'field' =>  'food_category',
                'label' =>  'food category',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            $fmm_id=$this->input->post('fm_id');
            $fc_name=$this->input->post('fc_name');
            $res_id1=$this->input->post('res_id');
            $inputs = array(
                'fc_name'    =>  $this->input->post("food_category")   
            );

             $this->food_m->update_food_category($fmm_id,$inputs);
            if($inputs>0)
            {
                $this->session->set_flashdata("msg_success", "Food Category updated successfully");
                redirect("restaurant/explore/".$res_id1."/".$fc_name);
            }
            else
            {
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("restaurant/explore/".$res_id1."/".$fc_name);
            }
        }
        $this->data['res']=$this->food_m->get_restaurant();
        $this->data['food_category']=$this->food_m->get_food_category();
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Update food Item";
        $this->data['view'] = "foodmenu/edit_food_category_form";
        $this->load->view("layout", $this->data);
    }

    // delete the Food category
    public function delete_food_category($fc_id, $res_id)
    {
        $fm_id=(int) $fc_id;
        $res_id=(int) $res_id;
        $this->food_m->delete_food_category($fc_id, $res_id);
        $this->session->set_flashdata("msg_success", "food Items has been permanently deleted!"); 
        redirect('foodmenu/add_food_category');
    }

    // this method is called by ajax for getting categories according to resturant id
    public function get_categories_by_id(){

        $res_id = $this->input->post('id');
        $myObj = $this->food_m->get_categories_by_id($res_id);
        $myJSON = json_encode($myObj);

        echo $myJSON;
    }
    // this method is called by ajax for getting categories according res_id which are not assigned to this resturant.
    public function get_categories_which_are_not_assigned_to_this_id(){
        $res_id = $this->input->post('id');
        $myObj = $this->food_m->get_categories_by_id_not_assigned_yet($res_id);
        $myJSON = json_encode($myObj);

        echo $myJSON;
    }
    
  }  