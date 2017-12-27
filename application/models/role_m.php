<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Role_m extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "roles";
        $this->pk = "role_id";
        $this->status = "role_status";
    }
    //-----------------------------------------------------------
    
    
    /**
     * function to get list of all roles and joining it with 
     * modules for homepage name
     */
    public function getRolesModule($module_status = "0,1,2"){
        
        $this->db->select("roles.*, modules.module_title");
        $this->db->from($this->table);
        $this->db->join("modules", "roles.role_homepage = modules.module_id", "inner");
        $this->db->where("roles.role_status in (".$module_status.")");
        $query = $this->db->get();
        return $query->result();
    }
}