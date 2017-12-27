<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Admin_Controller extends MY_Controller{
    
    public $controller_name = "";
    public $method_name = "";

    
    public function __construct(){
      
        parent::__construct();
        
       //$this->output->enable_profiler(TRUE);
       //var_dump($this->session->all_userdata());
        
        $this->load->helper("form");
        $this->load->helper("my_functions");
        $this->load->library('form_validation');
        $this->load->library("session");
        $this->load->model("restaurant_m");
        $this->load->model("user_m");
        $this->load->model("mr_m");
        $this->load->model("module_m");
        $this->data['controller_name'] = $this->controller_name = $this->router->fetch_class();
        $this->data['method_name'] = $this->method_name = $this->router->fetch_method();
        $this->data['menu_arr'] = $this->mr_m->roleMenu($this->session->userdata("role_id"));
        
        
        //login check
        $exception_uri = array(
            "users/login",
            "users/logout"
        );
       if(!in_array(uri_string(), $exception_uri)){
            
            if($this->uri->segment(2)!="receive_sms"){
            //check if the user is logged in or not
            if($this->user_m->loggedIn() == false){
                redirect("users/login");
            }
            
            //now we will check if the current module is assigned to the user or not
            $this->data['current_action_id'] = $current_action_id = $this->module_m->actionIdFromName($this->controller_name, $this->method_name);
            $allowed_modules = $this->mr_m->rightsByRole($this->session->userdata("role_id"));
            
            //add role homepage to allowed modules
            $allowed_modules[] = $this->session->userdata("role_homepage_id");
            
            //var_dump($allowed_modules);
            
            if(!in_array($current_action_id, $allowed_modules)){
                $this->session->set_flashdata('msg_error', 'You are not allowed to access this module');
                redirect($this->session->userdata("role_homepage_uri"));
            }
            }
        }
    }

    
    
    
}