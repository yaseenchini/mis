<?php
class Food_m extends CI_Model
{
  public function save($inputs)
  {
      return $this->db->insert('food_menu',$inputs);
  }

  public function get_restaurant()
  {
     $query=$this->db->get('restauratsn');
     if($query->num_rows()>0)
     {
     	return $query->result();
     }
     else
     {
     	return FALSE;
     }
  }

  public function get_food_category()
  {
     $query=$this->db->get('food_category');
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
    $this->db->from('food_menu');
    $this->db->join('restauratsn','restauratsn.res_id=food_menu.res_id');
    $this->db->group_by('res_name');
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

   public function view_all($res_id)
   {
      $this->db->select('*');
      $this->db->from('food_menu');
      $this->db->join('restauratsn','restauratsn.res_id=food_menu.res_id');
      $this->db->where('restauratsn.res_id',$res_id);
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

   public function delete_food_items($fm_id)
   {
      $this->db->where('fm_id',$fm_id);
      $this->db->delete('food_menu');
   }

   public function edit_food_items($fm_id)
  {
       $this->db->select('*');
       $this->db->from('restauratsn');
       $this->db->join('food_menu','restauratsn.res_id=food_menu.res_id');
       $this->db->where('fm_id',$fm_id);
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

  public function update_food_items($fmm_id,$inputs)
  {
      $this->db->where('fm_id',$fmm_id);
      $this->db->update('food_menu',$inputs);
  }

  // this block contains code for food category
  public function save_category($inputs)
  {
    $this->db->insert('food_category',$inputs);
    return $this->db->insert_id();
  }

   public function edit_food_category($fm_id)
  {
       $this->db->select('fc_id, fc_name');
       $this->db->from('food_category');
       $this->db->where('fc_id',$fm_id);
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

  public function update_food_category($fmm_id,$inputs)
  {
      $this->db->where('fc_id',$fmm_id);
      $this->db->update('food_category',$inputs);
  }

  public function delete_food_category($fc_id, $res_id)
  {       

         $this->db->where('fc_id', $fc_id);
         $this->db->where('res_id', $res_id);
         $query = $this->db->get('restro_food_category');
         $result = $query->result();
         if(count($result) >= 1){

          // delete all food item with res_id and fc_id...
          $this->db->where('fc_id',$fc_id);
          $this->db->where('res_id',$res_id);
          $this->db->delete('food_menu');
          //  delete all food categories with res_id & fc_id
          $this->db->where('fc_id',$fc_id);
          $this->db->where('res_id',$res_id);
          $this->db->delete('restro_food_category');
          $this->db->where('fc_id',$fc_id);
          $this->db->delete('food_category');
         }else{
          $this->db->where('fc_id',$fc_id);
          $this->db->delete('food_category');
          
      }
  }

  public function get_categories_by_id($res_id){
    $this->db->select("f.*");
      $this->db->from("restro_food_category r");
      $this->db->join("food_category f", "r.fc_id = f.fc_id");
      $this->db->where('r.res_id', $res_id);
      $this->db->group_by('r.fc_id');
      $query = $this->db->get();
      return $query->result();


  }

  public function get_categories_by_id_not_assigned_yet($res_id){
    $query = "SELECT food_category.fc_id, food_category.fc_name
              FROM food_category
              WHERE food_category.fc_id NOT IN (SELECT restro_food_category.fc_id FROM restro_food_category where restro_food_category.res_id=".$res_id.")";
    $query = $this->db->query($query);
    return $query->result();

  }

  // 
  public function restro_food_category_insert($inputs)
  {
    return $this->db->insert('restro_food_category',$inputs);
  }

}