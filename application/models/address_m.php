<?php
class Address_m extends CI_Model
{
	public function add_address($inputs)
	{
        $this->db->set($inputs);
        $this->db->insert('address');
	}

	public function add_sub_address($inputs)
	{
        $this->db->set($inputs);
        $this->db->insert('address');
	}

	public function address()
	{  
		$this->db->select('*');
		$this->db->from('address');
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

	public function view()
	{
		$this->db->select('*');
		$this->db->from('address');
		$this->db->group_by('title');
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

	public function view_all($addr_id)
	{
		$this->db->select('*');
		$this->db->from('address');
		$this->db->where('address.parent_id',$addr_id);
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

	public function delete_address($s_addr_id)
	{
       $this->db->delete('sub_address',array('s_addr_id'=>$s_addr_id));
	}

	public function edit_address($s_addr_id)
	{
       $this->db->select('*');
       $this->db->from('sub_address');
       $this->db->join('address','address.addr_id=sub_address.addr_id');
       $this->db->where('s_addr_id',$s_addr_id);
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

	public function update_address($adddr_id,$inputs)
	{
       $this->db->where('s_addr_id',$adddr_id);
       $this->db->update('sub_address',$inputs);
	}
}