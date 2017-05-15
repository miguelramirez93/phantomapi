<?php
class Tipodocumento extends CI_Model {

   function __construct(){
    parent::__construct();
   }

   public function get_tipodocumento($id) { # refactored
         if ($id === null){
           $this->db->select('*');
           $query = $this->db->get('tipo_documento');
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
           $query = $this->db->get_where('tipo_documento', array('id' => $id));
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
}
