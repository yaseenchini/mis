<?php
class Restaurant_m extends MY_Model
{
	public function insert($post)
	{
        // ->select('res_seqeunce')
        $array = $this->db->where('res_seqeunce >= ', $post['res_seqeunce'])->get('restauratsn');
        $data = $array->result_array();
        
        foreach ($data as $record) {
        	$res_seqeunce = intval($record['res_seqeunce']);
        	$incremented_sequence = $res_seqeunce + 1;
        	$config1 = array(
              'res_seqeunce' => $incremented_sequence      
            );
        	$this->db->where('res_id', $record['res_id']);
        	$this->db->update('restauratsn', $config1);
        }
        
        return $this->db->insert('restauratsn', $post);

	}

	public function getresturant(){
		// $this->db->where('res_visibility', 0);
		$this->db->order_by("res_seqeunce","desc");
		$query=$this->db->get('restauratsn');

		return $query->result_array();
	}
    
    public function get_max_seq(){
    	$this->db->select_max('res_seqeunce', 'max');
    	$result = $this->db->get('restauratsn');  
    	return $result->row()->max;

    }
     public function updateresturant($id)
     {
         $query=$this->db->where('res_id',$id)->get('restauratsn');
         return $query->result_array();


     }

	public function save($inputs,$res_id)
	{
		// fetching all records and updating by one value to adj
		$array = $this->db->where('res_seqeunce >= ', $inputs['res_seqeunce'])->get('restauratsn');
		$data = $array->result_array();
		foreach ($data as $record) {
			$res_seqeunce = intval($record['res_seqeunce']);
			$incremented_sequence = $res_seqeunce + 1;
			$config1 = array(
		      'res_seqeunce' => $incremented_sequence      
		    );
		    $this->db->where('res_id', $record['res_id']);
			$this->db->update('restauratsn', $config1);
		}
		// this method will simply update the desire restuerent
        $this->db->where('res_id',$res_id);
        $this->db->update('restauratsn',$inputs);
	}

	public function delete($id)
	{
	    $query = $this->db->where('res_id', $id)->get('restro_food_category');
	    $result = $query->result();
	    if(count($result) >= 1){

	    	$this->db->where('res_id', $id)->delete('food_menu');
	    	$this->db->where('res_id', $id)->delete('restro_food_category');
	    	$this->db->where('res_id', $id)->delete('restauratsn');  	
	    }else{
			$this->db->where('res_id',$id)->delete('restauratsn');
		}
	}

	public function get_items_from_menu_by_category_and_rest_id($category_id, $res_id)
	{	
		$this->db->select('fm_id, food_name, price, desc, res_id, food_type, quantity');
	    $this->db->where('food_type', $category_id);
	    $this->db->where('res_id', $res_id);
	    $query = $this->db->get('food_menu');
	    return $query->result();
	}
}