<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riders extends Admin_Controller
{
    
    public function __construct()
    {
        
        parent::__construct();
        $this->load->model('rider_m');
        
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
        $this->data['data']=$this->rider_m->view();
        $this->data['title'] = "List Riders";
        $this->data['view'] = "riders/list_riders";
        $this->load->view("layout", $this->data);
    
    }
    //-----------------------------------------------------
    
    
    
    /**
     * add new user
     */
    public function add_riders(){
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        
        //validation
        $valid_config = array(
            array(
                'field' => 'rider_name',
                'label' =>  'Name',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'office_no',
                'label' =>  'Office No',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'personal_no',
                'label' =>  'Personal No',
                'rules' =>  'trim|required|min_length[4]'
            ),
             array(
                'field' =>  'shift',
                'label' =>  'Shift',
                'rules' =>  'trim|required|min_length[4]'
            )
        );
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            
            $inputs = array(

                     'name'=>$this->input->post('rider_name'),
                     'office_no'=>$this->input->post('office_no'),
                     'personal_no'=>$this->input->post('personal_no'),
                      'shift'=>$this->input->post('shift'),
            );
            $this->rider_m->add_riders($inputs);
            if($inputs){
                $this->session->set_flashdata("msg_success", "New Rider created successfully");
                redirect("riders/add_riders");
            }else{
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("riders/add_riders");
            }
        }
        
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Create new rider";
        $this->data['view'] = "riders/add_riders";
        $this->load->view("layout", $this->data);
    }

    public function delete_riders($r_id)
    {
        $r_id=(int) $r_id;
        $this->rider_m->delete_riders($r_id);
        $this->session->set_flashdata("msg_success", "Rider has been permanently deleted!"); 
        redirect('riders/view');
    }

       public function update_riders($r_id)
       {
        
        //load other models
        $this->load->model("role_m");
        $this->load->model('department_m');
        
        $r_id = (int) $r_id;
        $this->data['riders'] = $this->rider_m->edit_user($r_id);
        
            //validation
        $valid_config = array(
            array(
                'field' => 'rider_name',
                'label' =>  'Name',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'office_no',
                'label' =>  'Office No',
                'rules' =>  'trim|required'
            ),
            array(
                'field' =>  'personal_no',
                'label' =>  'Personal No',
                'rules' =>  'trim|required|min_length[4]'
            ),
             array(
                'field' =>  'shift',
                'label' =>  'Shift',
                'rules' =>  'trim|required|min_length[4]'
            )
        );
   
        $this->form_validation->set_rules($valid_config);
        
        if($this->form_validation->run() === TRUE){
            $rr_id=$this->input->post('r_id');
             $inputs = array(
                     'name'=>$this->input->post('rider_name'),
                     'office_no'=>$this->input->post('office_no'),
                     'personal_no'=>$this->input->post('personal_no'),
                     'shift'=>$this->input->post('shift'),
            );
             $this->rider_m->update_riders($rr_id,$inputs);
            if($inputs>0)
            {
                $this->session->set_flashdata("msg_success", "Rider updated successfully");
                redirect("riders/view");
            }
            else
            {
                $this->session->set_flashdata("msg_error", "Something's wrong, Please try later");
                redirect("riders/view");
            }
        }
        
        $this->data['roles'] = $this->role_m->get();
        $this->data['departments'] = $this->department_m->getBy("parent_id = 0");
        $this->data['title'] = "Update user";
        $this->data['view'] = "riders/edit_riders";
        $this->load->view("layout", $this->data);
    }
    
     public function approvedbyadmin($riderid)
     {
         //echo $riderid;exit;
         $updatestatus=array(
             'status'=>2
             );
         $this->db->where('r_id',$riderid)->update('riders',$updatestatus);
         
         $updateapproval=array(
               'admin_approval'=>1
             );
             
             $this->db->where('r_id',$riderid)->update('riders',$updateapproval);
         
             redirect('riders/view');
     }
    
    
       public function ridercomments()
       {
           $riderid=$this->input->post('riderid');
           $ridercomment=$this->input->post('comment');
           $this->load->model('rider_m');
           $this->rider_m->ridercomments1($riderid,$ridercomment);
           redirect('riders/view');
       }
       
       public function activerider($riderid)
       {
           $updateriderstatus=array(
               'status'=>1,
               'admin_approval'=>3
               );
           
           $this->db->where('r_id',$riderid)->update('riders',$updateriderstatus);
           redirect('riders/view');
       }
       
       
       
       
       
       
       
    
}