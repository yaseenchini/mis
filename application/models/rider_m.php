<?php
class Rider_m extends CI_Model
{
	public function add_riders($inputs)
	{
       $this->db->set($inputs);
       $this->db->insert('riders');
	}

	public function view()
	{
		$query=$this->db->get('riders');
		if($query->num_rows()>0)
		{
           return $query->result();
		}
		else
		{
			return FALSE;
		}
		
	}

	public function delete_riders($r_id)
	{
        $this->db->where('r_id',$r_id);
        $this->db->delete('riders');
	}

	public function edit_user($r_id)
	{
		$this->db->where('r_id',$r_id);
		$query=$this->db->get('riders');
		if($query->num_rows()>0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function update_riders($rr_id,$inputs)
	{
        $this->db->where('r_id',$rr_id);
        $this->db->update('riders',$inputs);
	}
	
	    public function riderstatus($riderstatus)
    {
        switch($riderstatus)
        {
            case '1':
                return "present";
                break;
            case '2':
                return "leave";
                break;
            case '3':
                return "onbreak";
                break;
              default:
                  
                  break;
        }
    }
    
    public function adminapproval($status)
    {
        switch($status)
        {
            case '0':
                return "pending break";
                break;
            case '1':
                return "Approved";
                break;
                case '3':
                    return " ";
                    break;
              
            default:
                
                break;
        }
    }
    
    
    public function ridercomments1($riderid,$ridercomments)
    {
        $updaterider=array(
            'comments'=>$ridercomments
            );
            $this->db->where('r_id',$riderid)->update('riders',$updaterider);
    }
       
       
       public function active($status)
       {
           switch($status)
           {
               case '1':
                   return "Active";
                   break;
                   default:
                       
                       break;
           }
       }
    
    
    
      public function lastdelivery($riderid)
      {
          $this->db->select('*');
          $this->db->from('order');
          $this->db->join('order_addresses','order.o_id=order_addresses.o_id');
          $this->db->where('rider',$riderid);
          $query=$this->db->get();
          $result=$query->result_array();
          $lastlocation=$result[0]['order_address_id'];
          $this->db->select('*');
          $this->db->from('address');
          $this->db->where('addr_id',$lastlocation);
          $query=$this->db->get();
          $result1=$query->result_array();
          $lastlocation1=$result1[0]['title'];
          $customlocation=$result[0]['custom_addr'];
          return $lastlocation1." ".$customlocation;
          
      }
    
    
    
    
    
    
}