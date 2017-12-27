<?php
class Colddrink_m extends CI_Model
{
    public function add_colddrink($inputs)
    {
        $this->db->insert('crud_coldrinks',$inputs);
    }

    public function getallcoldrink()
    {
    	$this->db->select('*');
    	$this->db->from('crud_coldrinks');
    	$query=$this->db->get();
    	if($query->num_rows()>0)
    	{
    		return $query->result();
    	}
    	else
    	{
    		return FALSE;
    	}
    }

    public function delete_coldrink($colddrink_id)
    {
    	$this->db->where('colddrink_id',$colddrink_id);
    	$this->db->delete('crud_coldrinks');
    }

    public function edit_colddrink($colddrink_id)
    {
        $this->db->select('*');
        $this->db->from('crud_coldrinks');
        $this->db->where('colddrink_id',$colddrink_id);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return FALSE;
        }
    }

    public function update_colddrink($colddrinks_id,$inputs)
    {
       $this->db->where('colddrink_id',$colddrinks_id);
       $this->db->update('crud_coldrinks',$inputs);
    }
}