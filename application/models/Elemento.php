<?php
class Elemento extends CI_Model {

   function __construct(){
    parent::__construct();
   }

   public function get_elemento($id) { # refactored

     if ($id === null){
       $this->db->select('*');
       $query = $this->db->get('elemento');
       $result = $query->result_array();

       $count = count($result);

       if(empty($count)){
           return false;
       }
       else{
         $res = array();
         foreach ($result as $element) {//cargar todos los elementos relacionados de la tabla.
           $this->db->select('*');
           $query2 = $this->db->get_where('categoria_elemento', array('elemento' => $element['id']));
           $algo = $query2->result_array();
           foreach ($algo as $item) {
             $this->db->select('*');
             $query2 = $this->db->get_where('categoria', array('id' => $item['categoria']));
             $aux = $query2->result_array();
             $res2[] = $aux[0];
           }
           $element["categorias"] = $res2;
           $res[] = $element;
           $res2 = array();
         }
           return $res;
       }
     }else{
       $this->db->select('*');
       $query = $this->db->get_where('elemento', array('id' => $id));
       $result = $query->result_array();
       $count = count($result);

       if(empty($count)){
           return false;
       }
       else{
         $res = array();
         foreach ($result as $element) {//cargar todos los elementos relacionados de la tabla.
           $this->db->select('*');
           $query2 = $this->db->get_where('categoria_elemento', array('elemento' => $element['id']));
           $algo = $query2->result_array();
           $res2 = array();
           foreach ($algo as $item) {
             $this->db->select('*');
             $query2 = $this->db->get_where('categoria', array('id' => $item['categoria']));
             $aux = $query2->result_array();
             $res2[] = $aux[0];
           }
           $element["categorias"] = $res2;
           $res[] = $element;
           $res2 = array();
         }
           return $res;
           }

       }
     }


     public function add_elemento($elemento, $categorias){
       $this->db->trans_start();
       $this->db->insert('elemento',$elemento);
       $elementoid = $this->db->insert_id();
       foreach ($categorias as $categoria) {
         $row = [
           'elemento' => $elementoid,
           'categoria' => $categoria->id
         ];
         $this->db->insert('categoria_elemento',$row);
       }
       return $this->db->trans_complete();
     }


     public function delete_elemento($id){
       $this->db->trans_start();
       $this->db->delete('categoria_elemento', array('elemento' => $id));
       $this->db->delete('elemento', array('id' => $id));
       return $this->db->trans_complete();
     }

     public function put_elemento($data, $id){
       $this->db->trans_start();
       $this->db->where('id', $id);
       $elemento = $data->elemento;
       $this->db->update('elemento', $elemento);
       if ($data->eliminarcategorias != null){
         foreach ($data->eliminarcategorias as $element) {
           $this->db->delete('categoria_elemento', array('categoria' => $element->id, 'elemento' => $elemento->id));
         }
       }
       if ($data->agregarcategorias != null){
         foreach ($data->agregarcategorias as $element) {
           $this->db->insert('categoria_elemento', array('categoria' => $element->id, 'elemento' => $elemento->id));
         }
       }

       return $this->db->trans_complete();
     }
}
