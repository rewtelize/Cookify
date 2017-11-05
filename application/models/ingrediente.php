<?php
Class Ingrediente extends CI_Model
{
    function get_todos()
    {
        return $this->db->query("SELECT nombre FROM Ingrediente ORDER BY nombre ASC")->result_array();
    }

    /**
    * Funcion que añade un ingrediente a una receta dada
    */
    function nuevo_ingrediente($nuevo_ingrediente)
    {
        // Ingredientes separados por "," y campos del ingrediente separados por "-"
        $vector_ingredientes = explode(",", $nuevo_ingrediente);    
        $tam_vector_ingredientes = count($vector_ingredientes);
        for($i=0; $i<$tam_vector_ingredientes; $i++){
            $vector_del_ingrediente = explode("-", $vector_ingredientes[$i]);
            $tam_vector_del_ingrediente = count($vector_del_ingrediente);
            for($j=0; $j<$tam_vector_del_ingrediente; $j++){
                $data_ingrediente = array('cantidad' => $vector_del_ingrediente[0],
                                          'fraccion' => $vector_del_ingrediente[1],
                                          'id_ingrediente' => $vector_del_ingrediente[2],
                                          'id_receta' => $vector_del_ingrediente[3],
                                          'unidad' => $vector_del_ingrediente[4]);
            }
            $insercion_sql_ingrediente = $this->db->insert('receta_ingrediente', $data_ingrediente);
        }
    }
    
    /**
    * Funcion que añade una receta
    */
    function nueva_receta($nueva_receta)
    {
        $data_receta = array('dificultad' => $nueva_receta['dificultad'],
                             'fecha' => $nueva_receta['fecha'],
                             'foto' => $nueva_receta['foto'],
                             'id' => $nueva_receta['id'],
                             'id_autor' => $nueva_receta['id_autor'],
                             'nombre' => $nueva_receta['nombre'],
                             'num_valoraciones' => $nueva_receta['num_valoraciones'],
                             'tiempo' => $nueva_receta['tiempo'],
                             'tipo' => $nueva_receta['tipo'],
                             'valoracion' => $nueva_receta['valoracion']);
                      
        $this->nuevo_ingrediente($nueva_receta['ingrediente']);
                  
        $insercion_sql_receta = $this->db->insert('receta', $data_receta);
    }
    
    /**
    * Funcion que devuelve verdadero si la receta es del usuario
    */
    function receta_de_user($username, $receta)
    {
        $rs = $this->db->query("SELECT *
                                FROM Usuario u, Receta r 
                                WHERE u.nombre=$username AND r.nombre=$receta AND u.id=r.id_autor");

        if($rs->result_array()[0] == 0)
            return false;
        else
            return true;
    }

    /**
    * Devuelve el id del autor segun su nombre
    */
    function buscar_id_autor($nombre){
        $rs = $this->db->query("SELECT id FROM Usuario WHERE nombre = '$nombre' limit 1");
        //return $rs->row(0);
        //return intval($rs->result_array()[0]['id']);
        if($rs->result_array()[0] != 0)
            return intval($rs->result_array()[0]['id']);
        else
            return -1;
    }

    /**
    * Devuelve los ingredientes contenidos en una cadena
    */
    function ingredientes_en_string($filtros){
        $ingredientes="1";
        $v = explode(",", $filtros['ingredientes']);    // Vector de Strings de ingredientes separados
        //echo "v: ";
        //var_dump($v)
        $num_ingredientes_tmp = count($v);
        if($num_ingredientes_tmp > 0){
            for($i=0; $i<$num_ingredientes_tmp; $i++)
                $ingredientes = $ingredientes." and nombre = ".$v[$i];
            return $ingredientes;
        }

        else
            return FALSE;
    }

    /**
    * Devuelve el id de un ingrediente sabiendo su nombre
    */
    function get_id_ingrediente($ingrediente){
        $rs = $this->db->query("SELECT id FROM Ingrediente WHERE nombre = '$ingrediente' limit 1");
        if($rs->result_array() != null)
            return intval($rs->result_array()[0]['id']);
        else
            return -1;
    }

    /**
    * Devuelve el numero de ingredientes 
    */
    function num_ingredientes($filtros){
        $v = explode(",", $filtros['ingredientes']);    // Vector de Strings de ingredientes separados
        return count($v);
    }

}
?>