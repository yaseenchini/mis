<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Department_m extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "departments";
        $this->pk = "dept_id";
        $this->status = "dept_status";
    }
    //-----------------------------------------------------------
    
    
    
}