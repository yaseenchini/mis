<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Colddrink extends Admin_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('colddrink_m');
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
        $this->data['colddrink']=$this->colddrink_m->getallcoldrink();
        $this->data['title'] = "All process order";
        $this->data['view'] = "colddrink/colddrink_crud";
        $this->load->view("layout", $this->data);
    }
    //---------- save items in session and then show on modal for saving in cart item

    //-----------------------------------------------------  
    /**
     * add new user
     */
    public function add_colddrink(){
        
        $this->load->model("role_m");
        $this->load->model('department_m');
        //validation
        $valid_config = array(
            array(
                'field' => 'colddrink',
                'label' =>  'ColdDrink',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'liter',
                'label' =>  'Liter',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(

                     'colddrink'=>$this->input->post('colddrink'),
                     'liter'=>$this->input->post('liter')
            );
            $this->colddrink_m->add_colddrink($inputs);
            if($inputs){
                $this->session->set_flashdata("msg_success", "New coldrink created successfully");
                redirect("colddrink/add_colddrink");
            }else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("colddrink/add_colddrink");
            }
        }
        
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Create new colddrink";
        $this->data['view'] = "colddrink/add_colddrink";
        $this->load->view("layout", $this->data);
    }

     public function delete_colddrink($colddrink_id)
    {
        $colddrink_id=(int) $colddrink_id;
        $this->colddrink_m->delete_coldrink($colddrink_id);
        $this->session->set_flashdata("msg_success", "Colddrink has been permanently deleted!"); 
        redirect('colddrink/view');
    }

        public function update_colddrink($colddrink_id)
       {
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        $colddrink_id = (int) $colddrink_id;
        $this->data['edit_colddrink'] = $this->colddrink_m->edit_colddrink($colddrink_id);
            //validation
           $valid_config = array(
            array(
                'field' => 'colddrink',
                'label' =>  'ColdDrink',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'liter',
                'label' =>  'Liter',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        if($this->form_validation->run() === TRUE){
            $colddrinks_id=$this->input->post('colddrink_id');
             $inputs = array(
                   'colddrink'=>$this->input->post('colddrink'),
                    'liter'=>$this->input->post('liter'),
            );
            $this->colddrink_m->update_colddrink($colddrinks_id,$inputs);
            if($inputs>0)
            {
                $this->session->set_flashdata("msg_success", "Colddrink updated successfully");
                redirect("colddrink/view");
            }
            else
            {
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("colddrink/view");
            }
        }   
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Update address";
        $this->data['view'] = "colddrink/edit_colddrink";
        $this->load->view("layout", $this->data);
    }
}