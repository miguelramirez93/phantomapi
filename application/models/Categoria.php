<?php
class Categoria extends CI_Model {

   function __construct(){
    parent::__construct();
   }

   public function get_categoria($id) { # refactored

     if ($id === null){
       $this->db->select('*');
       $query = $this->db->get('categoria');
       $result = $query->result_array();

       $count = count($result);

       if(empty($count)){
           return false;
       }
       else{


           return $result;
       }
     }else{
       $this->db->select('*');
       $query = $this->db->get_where('categoria', array('id' => $id));
       $result = $query->result_array();
       $count = count($result);

       if(empty($count)){
           return false;
       }
       else{
            return $result;
           }

       }
     }


     public function add_categoria($data){
       return $this->db->insert('categoria',$data);
     }

     public function delete_categoria($id){
       return  $this->db->delete('categoria', array('id' => $id));
     }

     public function put_categoria($data, $id){
       $this->db->where('id', $id);
       return $this->db->update('categoria', $data);
     }
}
