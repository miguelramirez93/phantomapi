<?php
class Persona extends CI_Model {

   function __construct(){
    parent::__construct();
   }

   public function get_persona($id) { # refactored

     if ($id === null){
       $this->db->select('*');
       $query = $this->db->get('persona');
       $result = $query->result_array();

       $count = count($result);

       if(empty($count)){
           return false;
       }
       else{
           $res = array();
           foreach ($result as $element) {//cargar todos los elementos relacionados de la tabla.
             $this->db->select('*');
             $query2 = $this->db->get_where('tipo_persona', array('id' => $element['tipo_persona']));
             $algo = $query2->result_array();
             $element["tipo_persona"] = $algo[0];
             $this->db->select('*');
             $query2 = $this->db->get_where('tipo_documento', array('id' => $element['tipo_documento']));
             $algo = $query2->result_array();
             $element["tipo_documento"] = $algo[0];
             $res[] = $element;
           }
           return $res;
       }
     }else{
       $this->db->select('*');
       $query = $this->db->get_where('persona', array('id' => $id));
       $result = $query->result_array();
       $count = count($result);

       if(empty($count)){
           return false;
       }
       else{
           $res = array();
           foreach ($result as $element) {//cargar todos los elementos relacionados de la tabla.
             $this->db->select('*');
             $query2 = $this->db->get_where('tipo_persona', array('id' => $element['tipo_persona']));
             $algo = $query2->result_array();
             $element["tipo_persona"] = $algo[0];
             $this->db->select('*');
             $query2 = $this->db->get_where('tipo_documento', array('id' => $element['tipo_documento']));
             $algo = $query2->result_array();
             $element["tipo_documento"] = $algo[0];
             $res[] = $element;
           }
           return $res;
       }
     }
     }

     public function add_persona($data){
       return $this->db->insert('persona',$data);
     }

     public function delete_persona($id){
       return  $this->db->delete('persona', array('id' => $id));
     }

     public function put_persona($data, $id){
       $this->db->where('id', $id);
       return $this->db->update('persona', $data);
     }
}
