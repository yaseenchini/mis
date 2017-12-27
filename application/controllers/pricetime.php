<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Pricetime extends Admin_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pricetime_m');
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
        $this->data['pricetime']=$this->pricetime_m->getallpricetime();
        $this->data['title'] = "All process order";
        $this->data['view'] = "pricetime/pricetime_crud";
        $this->load->view("layout", $this->data);
    }
    //---------- save items in session and then show on modal for saving in cart item

    //-----------------------------------------------------  
    /**
     * add new user
     */
    public function add_pricetime(){
        
        $this->load->model("role_m");
        $this->load->model('department_m');
        //validation
        $valid_config = array(
            array(
                'field' => 'time',
                'label' =>  'Time',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'price',
                'label' =>  'Price',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(

                     'time'=>$this->input->post('time'),
                     'price'=>$this->input->post('price')
            );
            $this->pricetime_m->add_pricetime($inputs);
            if($inputs){
                $this->session->set_flashdata("msg_success", "New TimePrice created successfully");
                redirect("pricetime/add_pricetime");
            }else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("pricetime/add_pricetime");
            }
        }
        
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Create new TimePrice";
        $this->data['view'] = "pricetime/add_pricetime";
        $this->load->view("layout", $this->data);
    }

     public function delete_pricetime($time_price_id)
    {
        $time_price_id=(int) $time_price_id;
        $this->pricetime_m->delete_prcetime($time_price_id);
        $this->session->set_flashdata("msg_success", "Price time has been permanently deleted!"); 
        redirect('pricetime/view');
    }

        public function update_pricetime($time_price_id)
       {
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        $time_price_id = (int) $time_price_id;
        $this->data['edit_pricetime'] = $this->pricetime_m->edit_pricetime($time_price_id);
            //validation
           $valid_config = array(
            array(
                'field' => 'time',
                'label' =>  'Time',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'price',
                'label' =>  'Price',
                'rules' =>  'trim|required'
            )
        );
        $this->form_validation->set_rules($valid_config);
        if($this->form_validation->run() === TRUE){
            $time_price_ids=$this->input->post('time_price_id');
             $inputs = array(
                   'time'=>$this->input->post('time'),
                    'price'=>$this->input->post('price'),
            );
            $this->pricetime_m->update_pricetime($time_price_ids,$inputs);
            if($inputs>0)
            {
                $this->session->set_flashdata("msg_success", "Price time updated successfully");
                redirect("pricetime/view");
            }
            else
            {
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("pricetime/view");
            }
        }   
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Update address";
        $this->data['view'] = "pricetime/edit_pricetime";
        $this->load->view("layout", $this->data);
    }
}