<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Restaurant extends Admin_Controller
{
	 public function __construct()
	 {
        
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        //var_dump($this->session->all_userdata());
     }
    
    
    public function index()
    {
        $this->view();
    }


     public function view()
     {
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('restaurant_m');

        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['record'] = $this->restaurant_m->getresturant();
        $this->data['max1'] = $this->restaurant_m->get_max_seq();

        $this->data['title'] = "All Restaurant";
        $this->data['view'] = "restaurant/resturant";
        $this->load->view("layout", $this->data);

     }
     

      public function add_restaurant()
    {
           //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('restaurant_m');        
        //validation
        $valid_config = array(
            array(
                'field' => 'res_name',
                'label' =>  'Name',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'res_location',
                'label' =>  'location',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'res_contactno',
                'label' =>  'Contact No',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
            $data['res_image'] = $this->input->post('res_image');
            $res_image = $_FILES['res_image']['name'];  
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(
                'res_name'       =>  $this->input->post("res_name"),
                'res_location'       =>  $this->input->post("res_location"),
                'res_contactno'    =>  $this->input->post("res_contactno"),
                'res_image'    =>  $res_image,
                'res_seqeunce'       =>  $this->input->post("res_seqeunce"),
                'res_desc'       =>  $this->input->post("res_desc")
                                
            );

            // image uplaoding start here...
            $data['res_image'] = $res_image;
            $filename = preg_replace('/[^a-zA-Z0-9_.]/', '_', $data['res_image']);
            $filename = preg_replace('/_+/', '_', $file_name);
            // uploading starts here.....
            if(!empty($res_image)){
                $config['file_name'] = $filename;
                $config['remove_spaces'] = TRUE;
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                // $config['max_size']             = 100;
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;
                $this->load->library('upload', $config);

                if($this->upload->do_upload('res_image')){
                    // echo base_url().'uploads/'.$res_image;
                    // die;
                    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                    
                    $config1 = array(
                          'image_library' => 'gd2',
                          'create_thumb' => TRUE,
                          'thumb_marker' => '_thumb',
                          'source_image' => base_url().'uploads/'.$filename, //get original image
                          'new_image' => base_url().'uploads/thumbnails/'.$filename,
                          'maintain_ratio' => true,
                          'width' => 100,
                          'height' => 100
                          
                          
                        );
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($config1);
                        // $this->load->library('image_lib', $config1); //load library
                        if (!$this->image_lib->resize()) {
                                echo $this->image_lib->display_errors();
                            }

                }else{

                    $this->session->set_flashdata("msg_error", "Check image creteria not uploaded.");
                    redirect("restaurant/view");
                }
            }
            //uploading end here...





            if($this->restaurant_m->insert($inputs)){
                $this->session->set_flashdata("msg_success", "New restaurant created successfully");
                redirect("restaurant/view");
            }else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("restaurant/view");
            }
        }
        
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Add restaurant";
        $this->data['view'] = "restaurant/add_restaurant";
        $this->load->view("layout", $this->data);
    }
         
        
        public function edit_restaurant($id){
        
        //load other models

        $this->load->model("role_m");
        $this->load->model('department_m');
        $this->load->model('restaurant_m');
        
        $id = (int) $id;
        $this->data['record'] = $this->restaurant_m->updateresturant($id);
        
         //validation
        $valid_config = array(
            array(
                'field' => 'res_name',
                'label' =>  'Name',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'res_location',
                'label' =>  'Location',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'res_contactno',
                'label' =>  'Contact no',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'res_desc',
                'label' =>  'Description',
                'rules' =>  'trim'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE)
        {
            $res_id=$this->input->post("id");
            $inputs = array(
                'res_name'       =>  $this->input->post("res_name"),
                'res_location'       =>  $this->input->post("res_location"),
                'res_contactno'    =>  $this->input->post("res_contactno"),
                'res_desc'    =>  $this->input->post("res_desc"),
                'res_seqeunce'    =>  $this->input->post("res_seqeunce")
            );
            // below method in model is for update
            $this->restaurant_m->save($inputs, $res_id);
              if($inputs>0){

                $this->session->set_flashdata("msg_success", "Resturant updated successfully");
                redirect("restaurant/index");
            }else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("restaurant/index");
            }
        }
        
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Update Resturant";
        $this->data['view'] = "restaurant/edit_resturant";
        $this->load->view("layout", $this->data);
    }


    public function delete_restaurant($id){
        $this->restaurant_m->delete($id);
        redirect("restaurant/index");
    }

    // explore will explore resturants categories...
    public function explore($res_id, $res_name){
        $this->load->model('food_m');
        $this->data['res_id'] = $res_id;
        $this->data['res_name'] = str_replace("%20"," ",$res_name);

        $this->data['food_category'] = $this->food_m->get_categories_by_id($res_id);
        // $this->data['roles'] = $this->role_m->get();
        // $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['view'] = "restaurant/food_categories";
        $this->load->view("layout", $this->data);
    }

    // this method will explore all the items in selected category
    public function explore_items_of_categories($category_id, $res_id, $category_name){
        $this->data['res_id'] = $res_id;
        $this->data['category_id'] = $category_id;
        $this->data['category_name'] = str_replace("%20"," ",$category_name);
        $this->data['items']=$this->restaurant_m->get_items_from_menu_by_category_and_rest_id($category_id, $res_id);
        // $this->data['roles'] = $this->role_m->get();
        // $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Update Resturant";
        $this->data['view'] = "restaurant/food_items";
        $this->load->view("layout", $this->data);
    }

    public function toggle_visiblity(){
        $id = $this->input->post('id');
        $text = $this->input->post('text');
        if($text == 'Hidden'){
                $update_data = array(
                  'res_visibility' => 0      
                );
            $this->db->where('res_id', $id);
            $this->db->update('restauratsn', $update_data);
            return json_encode(true);
        }else{
                $update_data = array(
                  'res_visibility' => 1      
                );
            $this->db->where('res_id', $id);
            $this->db->update('restauratsn', $update_data);
            return json_encode(true);
        }
    }

}
    
