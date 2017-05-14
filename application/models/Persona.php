<?php
class Persona extends CI_Model {

   function __construct(){
    parent::__construct();
   }

   public function get_all_persona() { # refactored

         $this->db->select('*');
         $query = $this->db->get('persona');
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
