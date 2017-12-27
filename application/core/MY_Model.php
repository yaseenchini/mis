<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model{
    
    public $table = "";
    public $pk = "";
    public $status = "";
    
    public function __construct(){
        
        parent::__construct();
    }
    
    
    public function get($id = NULL){
        
        if($id != NULL){
            $this->db->where($this->pk, $id);
            $query = $this->db->get($this->table);
            return $query->row();
        }else{
            $query = $this->db->get($this->table);
            return $query->result();
        }
    }
    
    
    public function getBy($where, $single = false){
        
        $this->db->where($where);
        if($single != false){
            $this->db->limit(1);
            $query = $this->db->get($this->table);
            return $query->row();
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }
    //-----------------------------------------------------------
    
    
    
    
    /**
     * function to get a joined data from multiple tables
     * @param $fields array an array of fields to be selected from database
     * with table names as prefix e.g. users.user_name, users.user_id, roles.role_id
     * @param $table string parent table name
     * @param $join_table array of tables to be joined, name of table as index and
     * condition for joining as value
     * @return $data joined data
     */
    public function joinGet($fields, $table, $join_table, $where = NULL){
        
        //process the fields
        $fields_str = "";
        if(is_array($fields)){
            $fields_str = implode(", ", $fields);
        }else{
            $fields_str = $fields;
        }
        //select statement
        $this->db->select($fields_str);
        
        //parent table
        $this->db->from($table);
        
        //process the join
        foreach($join_table as $table_name => $condition){
            $this->db->join($table_name, $condition);
        }
        
        //add the condition
        if($where != NULL){
            $this->db->where($where);
        }
        
        //do the query
        $query = $this->db->get();
        return $query->result();
        
    }
    //-------------------------------------------------------
    
    
    
    /**
     * function to insert new data to a table
     * if $id is provieded it will edit that recored
     * @param $data array of field values pair
     * @param $id integer id of the record
     */
    public function save($data, $id = NULL){
        
        if($id != NULL){
            $this->db->set($data);
            $this->db->where($this->pk, $id);
            $this->db->update($this->table);
        }else{
            $this->db->set($data);
            $this->db->insert($this->table);
            $id = $this->db->insert_id();
        }
        return $id;
    }
    //----------------------------------------------------
    
    
    
    /**
     * function to change status of a recored
     * @param $id integer id of the record
     * @param $status integer status of the recored
     */
    public function changeStatus($id, $status = "1"){
        
        if(!$id){
            return false;
        }
        $this->db->set(array($this->status => $status));
        $this->db->where($this->pk, $id);
        $this->db->update($this->table);
        return $id;
    }
    //-------------------------------------------------------
    
    
    
    /**
     * function to get a specific column from a table
     * @param $col string column name
     * @param $id integer id of the record
     * @return $col_val mixed value of the column
     */
    public function getCol($col, $id){
        
        $id = (int) $id;
        $this->db->select($col);
        $this->db->from($this->table);
        $this->db->where($this->pk, $id);
        $this->db->limit(1);
        $query = $this->db->get();
        $obj = $query->row();
        return $obj->$col;
    }
    //-----------------------------------------------------
    
    
    
}