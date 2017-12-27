<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller{
    
    public function __construct(){
        
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        //var_dump($this->session->all_userdata());
    }
    
    
    public function index(){
        
        $this->view();
    }
    
    
    /**
     * get a list of all users
     */
    public function view(){
        
        $fields = array("users.*", "roles.role_title", "departments.dept_title");
        
        $join_table = array(
            "roles"=>"users.role_id = roles.role_id",
            "departments"=>"users.dept_id = departments.dept_id"
        );
        
        $where = "users.user_status in (0, 1, 2)";
        
        
        $this->data['title'] = "Users";
        $this->data['data'] = $this->user_m->joinGet($fields, "users", $join_table, $where);
        $this->data["view"] = "users/users";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------
    
    
    
    /**
     * add new user
     */
    public function add_user(){
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        
        //validation
        $valid_config = array(
            array(
                'field' => 'user_title',
                'label' =>  'User Fullname',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'user_email',
                'label' =>  'Email Address',
                'rules' =>  'trim|required|is_unique[users.user_email]|valid_email'
            ),
            array(
                'field' =>  'user_password',
                'label' =>  'Password',
                'rules' =>  'trim|required|min_length[4]'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(
                'role_id'       =>  $this->input->post("role_id"),
                'dept_id'       =>  $this->input->post("dept_id"),
                'user_title'    =>  $this->input->post("user_title"),
                'user_email'    =>  $this->input->post("user_email"),
                'user_name'     =>  $this->input->post("user_email"),
                'user_password' =>  $this->input->post("user_password"),
                'user_status'   =>  $this->input->post("user_status")
            );
            
            if($this->user_m->save($inputs)){
                $this->session->set_flashdata("msg_success", "New user created successfully");
                redirect("users/view");
            }else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("users/add_user");
            }
        }
        
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Create new user";
        $this->data['view'] = "users/add_user";
        $this->load->view("layout", $this->data);
    }
    //------------------------------------------------------------
    
    
    
    /**
     * add new user
     */
    public function edit_user($user_id){
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        $user_id = (int) $user_id;
        $this->data['user'] = $this->user_m->get($user_id);
        
        
        //validation
        $valid_config = array(
            array(
                'field' => 'user_title',
                'label' =>  'User Fullname',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'user_email',
                'label' =>  'Email Address',
                'rules' =>  'trim|required|valid_email|callback__unique_email[users.user_email]'
            ),
            array(
                'field' =>  'user_password',
                'label' =>  'Password',
                'rules' =>  'trim|required|min_length[4]'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(
                'role_id'       =>  $this->input->post("role_id"),
                'dept_id'       =>  $this->input->post("dept_id"),
                'user_title'    =>  $this->input->post("user_title"),
                'user_email'    =>  $this->input->post("user_email"),
                'user_name'     =>  $this->input->post("user_email"),
                'user_password' =>  $this->input->post("user_password"),
                'user_status'   =>  $this->input->post("user_status")
            );
            
            if($this->user_m->save($inputs, $user_id)){
                $this->session->set_flashdata("msg_success", "User updated successfully");
                redirect("users/edit_user/".$user_id);
            }else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("users/edit_user/".$user_id);
            }
        }
        
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Update user";
        $this->data['view'] = "users/edit_user";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------------------------
        
        
        
    /**
     * function to send a user to trash
     */
    public function trash_user($user_id){
        
        $user_id = (int) $user_id;
        $this->user_m->changeStatus($user_id, "3");
        $this->session->set_flashdata('msg_success', 'User has been sent to trash');
        redirect("users/view");
    }
    
    
    /**
     * function to list of trashed users
     */
    public function trashed_users(){
        
        $fields = array("users.*", "roles.role_title", "departments.dept_title");
        
        $join_table = array(
            "roles"=>"users.role_id = roles.role_id",
            "departments"=>"users.dept_id = departments.dept_id"
        );
        
        $where = "users.user_status in (3)";
        $this->data['title'] = "Trash";
        $this->data['data'] = $this->user_m->joinGet($fields, "users", $join_table, $where);
        $this->data["view"] = "users/trashed_users";
        $this->load->view("layout", $this->data);
    }
     //----------------------------------------------------------------------------
     
     
     
     /**
      * function to restor user from trash
      * @param $user_id integer
      */
     public function restore_user($user_id){
        
        $user_id = (int) $user_id;
        $this->user_m->changeStatus($user_id, "1");
        $this->session->set_flashdata("msg_success", "User has been restored");
        redirect("users/trashed_users");
     }
     //---------------------------------------------------------------------------
     
     
     /**
      * function to permanently delete role
      * @param $role_id integer
      */
     public function delete_user($user_id){
                
        $user_id = (int) $user_id;
        $this->user_m->changeStatus($user_id, "4");
        
        $this->session->set_flashdata("msg_success", "User has been permanently deleted!");
        redirect("users/trashed_users");
     }
     //----------------------------------------------------
     
     
     
     
     
     /**
      * function to login a user
      */
     public function login(){
        //check if the user is already logedin
        if($this->user_m->loggedIn() == TRUE){
            redirect("users/view");
        }
        
        //load other models
        $this->load->model("role_m");
        $this->load->model("module_m");
        
        $validations = array(
            array(
                'field' =>  'user_email',
                'label' =>  'Email Address',
                'rules' =>  'valid_email|required'
            ),
            array(
                'field' =>  'user_password',
                'label' =>  'Password',
                'rules' =>  'required'
            )
        );
        $this->form_validation->set_rules($validations);
        if($this->form_validation->run() === TRUE){
            
            $input_values = array(
                'user_email' => $this->input->post("user_email"),
                'user_password' => $this->input->post("user_password")
            );
            
            //get the user
            $user = $this->user_m->getBy($input_values, TRUE);
            if(count($user) > 0){
                
                //
                $role_homepage_id = $this->role_m->getCol("role_homepage", $user->role_id);
                $role_homepage_parent_id = $this->module_m->getCol("parent_id", $role_homepage_id);
                
                //now create homepage path
                $homepage_path = "";
                if($role_homepage_parent_id != 0){
                    $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_parent_id)."/";
                }
                $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_id);
                
                $user_data = array(
                    "user_id" => $user->user_id,
                    "user_email" => $user->user_email,
                    "user_title" => $user->user_title,
                    "role_id" => $user->role_id,
                    "role_homepage_id" => $role_homepage_id,
                    "role_homepage_uri" => $homepage_path,
                    "dept_id" => $user->dept_id,
                    "logged_in" => TRUE
                );
                
                //add to session
                $this->session->set_userdata($user_data);
                $this->session->set_flashdata('msg_success', "<strong>".$user->user_title.'</strong><br/><i>welcome to admin panel</i>');
                redirect($homepage_path);
            }else{
                $this->session->set_flashdata('msg', 'Email or password is incorrect');
                redirect("users/login");
            }
        }else{
            
            $this->data['title'] = "Login to dashboard";
            $this->load->view("users/login", $this->data);
        }
        
     }
     //--------------------------------------------------------------
     
     
     
     /**
      * logout a user
      */
     public function logout(){
        $this->user_m->logout();
        redirect("users/login");
     }
    
    
    
    /**
     * check unique on edit, custome callback validation function
     * @param $db_string string DB table and field name
     * @param $id integer id of the current edited item
     * @return boolean
     */
    public function _unique_email($email){
        
        $user_id = $this->uri->segment(3);
        
        $where = array(
            "user_email" => $email,
            "user_id != " => $user_id
        );
        $username = $this->user_m->getBy($where, TRUE);
        
        if(count($username)){
            $this->form_validation->set_message("_unique_email", "%s is already  in use, please enter another email ID");
            return false;
        }
        return true;
    }
     
}