<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');


class MY_Controller extends CI_Controller{
    
    public $data = array();
    
    
    public function __construct(){
        
        parent::__construct();
        $this->data['site_name'] = config_item("site_name");
        $this->data['errors'] = array();
    }
    
}