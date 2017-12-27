<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Addresses extends Admin_Controller
{
    
    public function __construct()
    {
        
        parent::__construct();
        $this->load->model('address_m');
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
        $this->load->model("role_m");
        $this->load->model('department_m'); 
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['data']=$this->address_m->view();
        $this->data['title'] = "List Riders";
        $this->data['view'] = "addresses/list_address";
        $this->load->view("layout", $this->data);
    
    }
    //-----------------------------------------------------
    
      public function view_all($addr_id)
     {
        $addr_id=(int) $addr_id;
        $this->load->model("role_m");
        $this->load->model('department_m'); 
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['data']=$this->address_m->view_all($addr_id);
        $this->data['title'] = "List Riders";
        $this->data['view'] = "addresses/view_all_address";
        $this->load->view("layout", $this->data);
    
    }
    
    
    /**
     * add new user
     */
    public function add_address()
    {
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        
        //validation
        $valid_config = array(
            array(
                'field' => 'address',
                'label' =>  'Address',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(

                     'title'=>$this->input->post('address')
            );
            $this->address_m->add_address($inputs);
            if($inputs>0)
            {
                $this->session->set_flashdata("msg_success", "New address created successfully");
                redirect("addresses/add_address");
            }
            else
            {
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("addresses/add_address");
            }
        }
        $this->data['address']=$this->address_m->address();
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Create new Address";
        $this->data['view'] = "addresses/add_address";
        $this->load->view("layout", $this->data);
    }

     public function add_sub_address()
     {
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        
        //validation
        $valid_config = array(
            array(
                'field' => 'sub_address',
                'label' =>  'Sub Address',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(

                     'title'=>$this->input->post('sub_address'),
                     'parent_id'=>$this->input->post('a_id')
            );
            $this->address_m->add_sub_address($inputs);
            if($inputs>0)
            {
                $this->session->set_flashdata("msg_success", "New Sub Address created successfully");
                redirect("addresses/add_address");
            }
            else
            {
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("addresses/add_address");
            }
        }
        
    }


    public function delete_address($s_addr_id)
    {
        $s_addr_id=(int) $s_addr_id;
        $this->address_m->delete_address($s_addr_id);
        $this->session->set_flashdata("msg_success", "Address has been permanently deleted!"); 
        redirect('addresses/view');
    }

    public function update_address($s_addr_id)
       {
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        $s_addr_id = (int) $s_addr_id;
        $this->data['edit_address'] = $this->address_m->edit_address($s_addr_id);
            //validation
        $valid_config = array(
            array(
                'field' => 'sub_address',
                'label' =>  'Address',
                'rules' =>  'trim|required'
            )
            
        );
   
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            $adddr_id=$this->input->post('s_addr_id');
             $inputs = array(
                   's_addr_title'=>$this->input->post('sub_address'),
                    'addr_id'=>$this->input->post('a_id'),
            );
             $this->address_m->update_address($adddr_id,$inputs);
            if($inputs>0)
            {
                $this->session->set_flashdata("msg_success", "Address updated successfully");
                redirect("addresses/view");
            }
            else
            {
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("addresses/view");
            }
        }
        
        $this->data['address']=$this->address_m->address();
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Update address";
        $this->data['view'] = "addresses/edit_address";
        $this->load->view("layout", $this->data);
    }
}