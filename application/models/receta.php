<?php
Class Receta extends CI_Model
{
    function get_recetas($array_autor, $limit=-1, $start=-1)
    {
        $query = "SELECT * FROM receta WHERE";
        foreach ($array_autor as $autor) 
            $query = $query . " id_autor=$autor or";
        $query = substr($query, 0, -2);
        $query = $query . "ORDER BY fecha DESC";
        if($limit!=-1)
            $query = $query." LIMIT $limit";
        if($start!=-1)
            $query = $query." OFFSET $start";
        return $this->db->query($query)->result_array();
    }

    function get_receta_by_id($id_receta)
    {
        return $this->db->query("SELECT * FROM receta WHERE id = $id_receta")->result_array()[0];
    }

    function get_ingredientes($id_receta)
    {
        return $this->db->query("SELECT * FROM receta_ingrediente WHERE id_receta = $id_receta")->result_array();
    }

    function get_pasos($id_receta)
    {
        return $this->db->query("SELECT descripcion FROM pasos WHERE id_receta = $id_receta ORDER BY id ASC")->result_array();
    }

    function borrar_recetas_de_user($id)
    {
        $id_recetas = $this->db->query("SELECT id FROM receta WHERE id_autor=$id")->result_array();
        foreach ($id_recetas as $k => $v) 
            $this->borrar_receta($v['id']);
    }

    function borrar_receta($id_receta)
    {
        $this->db->query("DELETE FROM pasos WHERE id_receta = $id_receta");
        $this->db->query("DELETE FROM receta_ingrediente WHERE id_receta = $id_receta");
        $this->db->query("DELETE FROM valoracion WHERE id_receta = $id_receta");
        $this->db->query("DELETE FROM comentarios WHERE id_receta = $id_receta");
        $this->db->query("DELETE FROM receta WHERE id = $id_receta");
    }

    function actualizar_receta($nueva_receta)
    {
        //var_dump($nueva_receta);
        $query = "UPDATE RECETA SET ";
        $len = strlen($query);

        if(!is_null($nueva_receta['dificultad']))
            $query = $query."dificultad = $nueva_receta[dificultad], ";
        if(!is_null($nueva_receta['foto']))
            $query = $query."foto = '".addslashes($nueva_receta['foto'])."', ";
        if($nueva_receta['nombre'] != '')
            $query = $query."nombre = '$nueva_receta[nombre]', ";
        if($nueva_receta['tiempo'] != '0')
            $query = $query."tiempo = $nueva_receta[tiempo], ";
        if($nueva_receta['tipo'] != '')
            $query = $query."tipo = '$nueva_receta[tipo]', ";

        if($len != strlen($query))
        {
            $query = substr($query, 0, -2);
            $query = $query . " WHERE id = $nueva_receta[id]";
            $this->db->query($query);
        }

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
                                          'fraccion' => "0",
                                          'id_ingrediente' => intval($this->get_id_ingrediente($vector_del_ingrediente[1])),
                                          'id_receta' => intval($vector_del_ingrediente[2]),
                                          'unidad' => $vector_del_ingrediente[3]);
            }
            $insercion_sql_ingrediente = $this->db->insert('receta_ingrediente', $data_ingrediente);
        }
    }
    
    /**
    * Funcion que añade una receta
    */
    function nueva_receta($nueva_receta)
    {
        $nueva_receta['foto'] = addslashes($nueva_receta['foto']);
        $this->db->query("INSERT INTO Receta (nombre,tipo,valoracion,num_valoraciones,id_autor,fecha,dificultad,tiempo,foto) VALUES 
            ('$nueva_receta[nombre]','$nueva_receta[tipo]',1,0,$nueva_receta[id_autor],NOW(),$nueva_receta[dificultad],$nueva_receta[tiempo],'$nueva_receta[foto]')");
        $id_receta = $this->db->insert_id();

        $ingredientes = "";
        for($i=0; $i<6; $i++)
            if($nueva_receta['ingredientes'][$i]['nombre'] != '')
            $ingredientes = $ingredientes.$nueva_receta['ingredientes'][$i]['cantidad']."-".
                                                        $nueva_receta['ingredientes'][$i]['nombre']."-".
                                                        $id_receta."-".
                                                        $nueva_receta['ingredientes'][$i]['unidad'].",";
        if($ingredientes != "")
        {
            $ingredientes = substr($ingredientes, 0, -1);          
            $this->nuevo_ingrediente($ingredientes);
        }

        return $id_receta;
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
    * Devuelve los ingredientes contenidos en una cadena
    */
    function ingredientes_en_string($filtros){
        //$ingredientes="1";
        $v = explode(",", $filtros['ingredientes']);    // Vector de Strings de ingredientes separados
        $v=array_map('trim',$v);                        // Esta funcion elimina posibles espacios dentro de una misma posicion
        $num_ingredientes_tmp = count($v);
        if($num_ingredientes_tmp > 0){
            /*
            for($i=0; $i<$num_ingredientes_tmp; $i++)
                $ingredientes = $ingredientes." and nombre = "."'$v[$i]'";
            return $ingredientes;                       // Devolver un vector en el que cada posicion sea un ingrediente, sin espacios
            */
            return $v;
        }

        else
            return 0;
    }

    /**
    * Devuelve el id de un ingrediente sabiendo su nombre
    */
    function get_id_ingrediente($ingrediente){
        $rs = $this->db->query("SELECT id FROM Ingrediente WHERE nombre = '$ingrediente' limit 1"); // $ingrediente esta devolviendo un entero
        
        if($rs->result_array() != null)
            return intval($rs->result_array()[0]['id']);
        else
            return -1;
    }

    function get_nombre_ingrediente($id){
        $rs = $this->db->query("SELECT nombre FROM Ingrediente WHERE id = '$id' limit 1");
        if($rs->result_array() != null)
            return $rs->result_array()[0]['nombre'];
        else
            return -1;
    }

    function insertar_ingrediente($datos)
    {
        $this->db->query("INSERT INTO receta_ingrediente (id_receta, id_ingrediente, cantidad, unidad, fraccion) VALUES 
                                    ($datos[3],$datos[0],$datos[1],'$datos[2]',0)");
    }

    function borrar_ingrediente($id_receta)
    {
        $id = $this->db->query("SELECT MAX(id) as id FROM Receta_ingrediente WHERE id_receta = $id_receta")->result_array()[0]['id'];
        $this->db->query("DELETE FROM Receta_ingrediente WHERE id = $id");
    }

    function insertar_paso($datos)
    {
        $this->db->query("INSERT INTO pasos (id_receta, descripcion) VALUES 
                                    ($datos[0],'$datos[1]')");
    }

    function borrar_paso($id_receta)
    {
        $id = $this->db->query("SELECT MAX(id) as id FROM pasos WHERE id_receta = $id_receta")->result_array()[0]['id'];
        $this->db->query("DELETE FROM pasos WHERE id = $id");
    }

    /**
    * Devuelve el numero de ingredientes 
    */
    function num_ingredientes($filtros){
        $v = explode(",", $filtros['ingredientes']);    // Vector de Strings de ingredientes separados

        if($v[0] == '')
            return 0;
        else
            return count($v);
    }

    function filtrado($filtros, $limit, $start) {
        // Autor de la receta
        $autor="1";
        if($filtros['autor']!=''){
            $num_autor = $this->db->query("SELECT id FROM usuario WHERE nombre = '$filtros[autor]'")->result_array()[0]['id'];;
            if($num_autor != -1)
              $autor="id_autor = ".$num_autor;
        }

        // Nombre de la receta
        if($filtros['nombre']=='')
            $nombre="1";
        else
            $nombre="nombre LIKE '%".$filtros['nombre']."%'";

        // Tipo de la receta
        if($filtros['tipo']=='')
            $tipo="1";
        else
            $tipo="tipo = '".$filtros['tipo']."'";
            
        // Tiempo maximo de la receta
        $tiempo="tiempo <= ".$filtros['tmp-max'];
            

        // Dificultad de la receta
        $dificultad="dificultad in (";
        if($filtros['dificultad_f']!=null)
            $dificultad=$dificultad."1,";
        if($filtros['dificultad_m']!=null)
            $dificultad=$dificultad."2,";
        if($filtros['dificultad_d']!=null)
            $dificultad=$dificultad."3,";
        $dificultad = substr($dificultad, 0, -1);
        $dificultad=$dificultad.")";

        // Ingredientes de la receta
        $num_ingredientes = $this->num_ingredientes($filtros);
        $ingredientes_string = $this->ingredientes_en_string($filtros);

        
        $ingredientes_id = "";
        
        // Convertimos los nombres de los ingredientes en id
        for($i=0; $i<$num_ingredientes; $i++){
            if($this->get_id_ingrediente($ingredientes_string[$i]) != "-1"){
                $ingredientes_id = $ingredientes_id."(select id_receta from receta_ingrediente where id_ingrediente = ".$this->get_id_ingrediente($ingredientes_string[$i]).") and id_receta in ";
            }
            else
                $num_ingredientes=-1;                           // El usuario se ha equivocado al introducir un ingrediente
        }

        // Receta que contiene todos esos ingredientes
        $consulta_ingredientes = "SELECT DISTINCT id_receta FROM Receta_ingrediente WHERE id_receta in".$ingredientes_id."(select id_receta from receta_ingrediente)";
        //echo "<br>".$consulta_ingredientes."</br>";


        // Consulta final con ingredientes
        if($num_ingredientes > 0){
            $query = "SELECT * FROM Receta WHERE $autor AND $nombre AND $tipo AND $dificultad AND $tiempo 
                    AND valoracion <= ".intval($filtros['val_max'])." AND valoracion >= ".intval($filtros['val_min'])." 
                                        AND id in
                                            (".$consulta_ingredientes.")";
            if($limit!=-1 && $start!=-1)
                $query = $query." LIMIT $limit OFFSET $start ";
            $rs = $this->db->query($query);
            return $rs->result_array();
        }
        

        if($num_ingredientes==0){   // No hay ingredientes
            $query = "SELECT * FROM Receta WHERE $autor AND $nombre AND $tipo AND $dificultad AND $tiempo 
                    AND valoracion <= ".intval($filtros['val_max'])." AND valoracion >= ".intval($filtros['val_min']);
            if($limit!=-1 && $start!=-1)
                $query = $query." LIMIT $limit OFFSET $start ";
            $rs = $this->db->query($query);
            return $rs->result_array();
            
        }

        if($num_ingredientes < 0){
            echo "<br> Error al introducir el ingrediente </br>";
        }
        

                               
    }

    /* ************ FUNCIONES DE COMENTARIO ************ */
    function get_comentarios($id_receta, $limit=-1, $page=-1)
    {

        /*AQUI TU CONSULTA */
        $query="SELECT * FROM comentarios WHERE id_receta = $id_receta ORDER BY fecha DESC";

        /* ESTO ES NECESARIO PARA LA PAGINACION */
        if($limit!=-1)
            $query = $query . " LIMIT $limit";
        if($page!=-1)
            $query = $query . " OFFSET $page";
        /* ********************************** */

        /** return result_array() **/
        $rs = $this->db->query($query);
        //var_dump($query);
        return $rs->result_array();
    }

    function nuevo_comentario($id_receta, $id_comentador, $comentario)
    {
        /** INSERCION DE COMENTARIO **/
        $fecha_string = $this->db->query("SELECT now()")->result_array()[0];
        $fecha = $fecha_string['now()'];
        //var_dump($fecha);
        $this->db->query("INSERT INTO `comentarios`(`id_receta`, `id_comentador`, `comentario`, `fecha`) VALUES ($id_receta, $id_comentador, '$comentario', '$fecha')");
    }

    function borrar_comentario($id_receta, $id_comentario)
    {
        /** ELIMINACION DE COMENTARIO **/
        $this->db->query("DELETE FROM `comentarios` WHERE id_receta = $id_receta AND id = $id_comentario");
    }

    function borrar_comentarios_de_user($id)
    {
        $this->db->query("DELETE FROM comentarios WHERE id_comentador = $id");
    }

    function valorar($id_receta, $id_valorador, $valoracion)
    {
        $valoraciones_totales = $this->db->query("SELECT puntuacion FROM valoracion WHERE id_receta = $id_receta")->result_array();
        $total = 0;
        foreach ($valoraciones_totales as $k => $v) 
            $total += $v['puntuacion'];

        $valoraciones = $this->db->query("SELECT valoracion, num_valoraciones FROM receta WHERE id = $id_receta")->result_array()[0];
        $valoraciones['num_valoraciones']++;
        $valoraciones['valoracion'] = ceil(($total + $valoracion) / $valoraciones['num_valoraciones']);

        $this->db->query("UPDATE receta SET valoracion = $valoraciones[valoracion], num_valoraciones = $valoraciones[num_valoraciones] 
                            WHERE id = $id_receta");

        $this->db->query("INSERT INTO valoracion (id_usuario,id_receta,puntuacion) 
                            VALUES ($id_valorador,$id_receta,$valoracion)");
        
    }

    function borrar_valoracion($id_receta, $id_valorador)
    {
        $valoraciones_totales = $this->db->query("SELECT puntuacion FROM valoracion WHERE id_receta = $id_receta")->result_array();
        $total = 0;
        foreach ($valoraciones_totales as $k => $v) 
            $total += $v['puntuacion'];

        $valoracion = $this->db->query("SELECT puntuacion FROM valoracion WHERE id_receta = $id_receta AND id_usuario=$id_valorador")->result_array()[0]['puntuacion'];

        $valoraciones = $this->db->query("SELECT valoracion, num_valoraciones FROM receta WHERE id = $id_receta")->result_array()[0];
        $valoraciones['num_valoraciones']--;
        $valoraciones['valoracion'] = ceil(($total - $valoracion) / $valoraciones['num_valoraciones']);

        if($valoraciones['valoracion'] == 0)
            $valoraciones['valoracion'] = 1;

        $this->db->query("UPDATE receta SET valoracion = $valoraciones[valoracion], num_valoraciones = $valoraciones[num_valoraciones] 
                            WHERE id = $id_receta");

        $this->db->query("DELETE FROM valoracion WHERE id_usuario = $id_valorador AND $id_receta = $id_receta");
        
    }

    function borrar_valoraciones_de_user($id)
    {
        $id_recetas = $this->db->query("SELECT id_receta FROM valoracion WHERE id_usuario=$id")->result_array();
        foreach ($id_recetas as $key => $value) 
            $this->borrar_valoracion($value['id_receta'],$id);
    }

    function valoracion($id_receta, $id_usuario)
    {
        $voto = $this->db->query("SELECT * from valoracion WHERE id_receta=$id_receta AND id_usuario=$id_usuario")->result_array();
        if(empty($voto))
            return false;
        else
            return $voto[0];
    }
}

?>