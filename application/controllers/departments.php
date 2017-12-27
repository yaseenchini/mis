<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Departments extends Admin_Controller{
    
    public function __construct(){
        
        parent::__construct();
        $this->load->model("role_m");
    }
    //--------------------------------------------------
    
    
    public function index(){
        $this->view();
    }
    //--------------------------------------------------
    
    public function view(){
        
        $fields = "roles.*, modules.module_title";
        $join  = array(
            "modules" => "roles.role_homepage = modules.module_id"
        );
        $where = "roles.role_status in (0,1,2)";
        
        $this->data['title'] = "Roles";
        $this->data['data'] = $this->role_m->joinGet($fields, "roles", $join, $where);
        $this->data["view"] = "roles/roles";
        $this->load->view("layout", $this->data);
    }
    //--------------------------------------------------------
    
    
    /**
     * add new role
     */
    public function add_department(){
        
        //load required models
        $this->load->model("mr_m");
        $this->load->model("module_m");
        $module_ids = explode(",", $this->input->post("checked_modules"));
        
        
        
        //validation configuration
        $validation_config = array(
            array(
                'field' =>  'role_title',
                'label' =>  'Role Title',
                'rules' =>  'trim|required'
            ),
            array(
                'field' => 'role_level',
                'label' => 'Role Level',
                'rules' => 'trim|required'
            ),
            array(
                'field' =>  'checked_modules',
                'label' =>  'Modules',
                'rules' =>  'trim|is_string'
            )
        );
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(
                'role_title'    =>  $this->input->post('role_title'),
                'role_desc'     =>  $this->input->post('role_desc'),
                'role_homepage' =>  $this->input->post('role_homepage'),
                'role_level'    =>  $this->input->post('role_level'),
                'role_status'   =>  $this->input->post('role_status')
            );
            
            $role_id = $this->role_m->save($inputs);
            
            if($role_id){
                //now save all checked modules
                $compiled_module_ids = $this->module_m->compileModuleIds($module_ids);
                if(count($compiled_module_ids) > 1){
                    $this->mr_m->addRights($role_id, $compiled_module_ids);
                }
                $this->session->set_flashdata('msg', 'New role has been created successfully');
                redirect('roles/roles');
            }else{
                $this->session->set_flashdata('msg', 'Failed');
                redirect('roles/add_role');
            }
        }else{
            
            $this->data['module_tree'] = $this->module_m->modulesTree();
            $this->data['modules'] = $this->module_m->get();
            $this->data['title'] = "Create new role";
            $this->data['view'] = "roles/add_role";
            $this->load->view("layout", $this->data);
        }
    }
    //--------------------------------------------------------------
    
    
    /**
     * edit a role
     * @param $role_id integer
     */
    public function edit_department($role_id){
        
        //load required models
        $this->load->model("mr_m");
        $this->load->model("module_m");
         
        //get this controller data to populate form
        $role_id = (int) $role_id;
        $this->data['role'] = $this->role_m->get($role_id);
        $module_ids = explode(",", $this->input->post("checked_modules"));
        
    
        //validation configuration
        $validation_config = array(
            array(
                'field' =>  'role_title',
                'label' =>  'Role Title',
                'rules' =>  'trim|required'
            ),
            array(
                'field' => 'role_level',
                'label' => 'Role Level',
                'rules' => 'trim|required'
            ),
            array(
                'field' =>  'checked_modules',
                'label' =>  'Modules',
                'rules' =>  'trim|is_string'
            )
        );
        $this->form_validation->set_rules($validation_config);
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(
                'role_title'    =>  $this->input->post('role_title'),
                'role_desc'     =>  $this->input->post('role_desc'),
                'role_homepage' =>  $this->input->post('role_homepage'),
                'role_level'    =>  $this->input->post('role_level'),
                'role_status'   =>  $this->input->post('role_status')
            );
            
            if($this->role_m->save($inputs, $role_id)){
                
                //now lets process modules rights
                $this->mr_m->deleteRights($role_id);
                //get parent module ids and compile the array
                $compiled_module_ids = $this->module_m->compileModuleIds($module_ids);
                if(count($compiled_module_ids) > 1){
                    $this->mr_m->addRights($role_id, $compiled_module_ids);
                }
                
                
                $this->session->set_flashdata('msg', 'Role has been updated successfully');
                redirect('roles/edit_role/'.$role_id);
            }else{
                $this->session->set_flashdata('msg', 'Ooppss! something went wrong.');
                redirect('roles/edit_role/'.$role_id);
            }
        }else{
            
            $this->data['module_tree'] = $this->module_m->modulesTree();
            $this->data['this_role_rights'] = $this->mr_m->rightsByRole($role_id);
            $this->data['modules'] = $this->module_m->get();
            $this->data['title'] = "Edit role";
            $this->data['view'] = "roles/edit_role";
            $this->load->view("layout", $this->data);
        }
    }
    //-----------------------------------------------------------------------
        
        
        
    /**
     * function to send a role to trash
     */
    public function trash_department($role_id){
        
        $role_id = (int) $role_id;
        $this->role_m->changeStatus($role_id, "3");
        $this->session->set_flashdata('msg', 'Role has been send to trash');
        redirect("roles/roles");
    }
    
    
    /**
     * function to list of trashed roles
     */
    public function trashed_departments(){
        
        $this->data['title'] = "Trash";
        $this->data['data'] = $this->role_m->getRolesModule("3");
        $this->data["view"] = "roles/trashed_roles";
        $this->load->view("layout", $this->data);
    }
     //----------------------------------------------------------------------------
     
     
     
     /**
      * function to restor role from trash
      * @param $role_id integer
      */
     public function restore_department($role_id){
        
        $role_id = (int) $role_id;
        $this->role_m->changeStatus($role_id, "1");
        $this->session->flashdata("msg", "Role has been restored");
        redirect("roles/trashed_roles");
     }
     //---------------------------------------------------------------------------
     
     
     /**
      * function to permanently delete role
      * @param $role_id integer
      */
     public function delete_department($role_id){
        
        $this->load->model("mr_m");
        
        $role_id = (int) $role_id;
        $this->role_m->changeStatus($role_id, "4");
        
        //now delete all rights of this role
        $this->mr_m->deleteRights($role_id);
        
        $this->session->set_flashdata("msg", "Role has been permanently deleted!");
        redirect("roles/trashed_roles");
     }
     //-------------------------------------------------------------------------------
     
     /*public function test($r){
        $this->load->model("mr_m");
        $this->mr_m->rightsByRole($r);
     }*/
      
}