<?php
class Pricetime_m extends CI_Model
{
    public function add_pricetime($inputs)
    {
        $this->db->insert('crud_timeprice',$inputs);
    }

    public function getallpricetime()
    {
    	$this->db->select('*');
    	$this->db->from('crud_timeprice');
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

    public function delete_prcetime($time_price_id)
    {
    	$this->db->where('time_price_id',$time_price_id);
    	$this->db->delete('crud_timeprice');
    }

    public function edit_pricetime($time_price_id)
    {
        $this->db->select('*');
        $this->db->from('crud_timeprice');
        $this->db->where('time_price_id',$time_price_id);
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

    public function update_pricetime($time_price_ids,$inputs)
    {
       $this->db->where('time_price_id',$time_price_ids);
       $this->db->update('crud_timeprice',$inputs);
    }
}