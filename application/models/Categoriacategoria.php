<?php
class Categoriacategoria extends CI_Model {

   function __construct(){
    parent::__construct();
   }

   public function generar_arbol ($data){
     if ($data === NULL){
       return NULL;
     }else{
       $sql = "SELECT categoria.id, nombre, descripcion from categoria join categoria_categoria on  categoria_categoria.categoria_hijo = categoria.id WHERE categoria_categoria.categoria_padre = ? ";
       $query = $this->db->query($sql,$data);
       $row = $query->result_array();
       $res = array();
       foreach ($row as $son) {
         $son["children"] = $this->generar_arbol($son["id"]);
         $res[] = $son;
       }
       return $res;
     }


   }


   public function get_categoriacategoria() { # refactored

       $query = $this->db->query("SELECT id , nombre, descripcion from categoria where id not in (select DISTINCT categoria_padre from categoria_categoria) AND id not in (select DISTINCT categoria_hijo from categoria_categoria) OR (id  in (select DISTINCT categoria_padre from categoria_categoria) AND id not in (select DISTINCT categoria_hijo from categoria_categoria))");
        $row = $query->result_array();
        $res = array();
        foreach ($row as $son) {
          $son["children"] = $this->generar_arbol($son["id"]);
          $res[] = $son;
        }
        return $res;


     }

     public function add_categoriacategoria($data){
       return $this->db->insert('categoria_categoria',$data);
     }

     public function delete_categoriacategoria($id){
       return  $this->db->delete('categoria_categoria', array('id' => $id));
     }

     public function put_categoriacategoria($data, $id){
       $this->db->where('id', $id);
       return $this->db->update('categoria_categoria', $data);
     }
}
