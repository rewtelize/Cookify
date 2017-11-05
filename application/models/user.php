<?php
Class User extends CI_Model
{
    function login($username, $password)
    {
        $rs = $this->db->query("SELECT id, tipo, nombre, foto, email, pass 
        							FROM Usuario 
        							WHERE nombre='".$username."' AND pass='".md5($password)."'");
        if($rs == null)
            return false;
        else if(empty($rs->result_array()))
            return false;
        else
            return $rs->result_array()[0];
    }

    function es_admin($id_user)
    {
        if($this->db->query("SELECT tipo FROM usuario WHERE id = $id_user")->result_array()[0]['tipo'] == '0')
            return true;
        else 
            return false;

    }

    function exists($username)
    {
        $rs = $this->db->query("SELECT id FROM Usuario WHERE nombre='".$username."'");
        if(empty($rs->result_array()))
            return false;
        else
            return true;
    } 

     function exists_email($email)
    {
        $rs = $this->db->query("SELECT id FROM Usuario WHERE email='".$email."'");
        if(empty($rs->result_array()))
            return false;
        else
            return true;
    } 

    function save($data)
    {
        $data['pp'] = addslashes($data['pp']);
        $rs = $this->db->query("INSERT INTO Usuario (tipo,nombre,pass,foto,email) VALUES 
                                (1,'$data[u]','" . md5($data['p']) . "','".$data['pp']."','$data[e]')");
    }

    function nuevo_nombre($id, $username)
    {
        $this->db->query("UPDATE usuario SET nombre='$username' WHERE id = $id");
    }

    function nuevo_password($id, $password)
    {
        $this->db->query("UPDATE usuario SET password='".md5($password)."' WHERE id = $id");
    }

    function nuevo_email($id, $email)
    {
        $this->db->query("UPDATE usuario SET email='$email' WHERE id = $id");
    }

    function nueva_foto($id, $foto)
    {
        $foto = addslashes($foto);
        $this->db->query("UPDATE usuario SET foto='$foto' WHERE id = $id");
    }

    function get_num_recetas($username)
    {
        $rs = $this->db->query("SELECT COUNT(*) AS num FROM receta r, usuario u WHERE r.id_autor = u.id AND u.nombre='$username'");
        return $rs->result_array()[0];
    }

    function get_username($id)
    {
        return $this->db->query("SELECT nombre FROM usuario WHERE id = '$id'")->result_array()[0]['nombre'];
    }

    function get_id($username)
    {
        return $this->db->query("SELECT id FROM usuario WHERE nombre = '$username'")->result_array()[0]['id'];
    }

    function get_user_info_by_username($username)
    {
        return $this->db->query("SELECT id,nombre,foto,email FROM usuario WHERE nombre = '$username'")->result_array()[0];
    }

    function get_user_info_by_id($id)
    {
        return $this->db->query("SELECT id,nombre,foto,email FROM usuario WHERE id = $id")->result_array()[0];
    }

    function get_user_pp($id)
    {
        return $this->db->query("SELECT foto FROM usuario WHERE id = $id")->result_array()[0]['foto'];
    }

    function busqueda_por_username($username,$limit=-1,$offset=-1)
    {
        $query = "SELECT id,nombre,foto,email FROM usuario WHERE nombre LIKE '%$username%'";

        if($limit != -1)
            $query = $query . " LIMIT $limit ";
        if($offset != -1)
            $query = $query . " OFFSET $offset ";

        return $this->db->query($query)->result_array();
    }

    function borrar_usuario($id)
    {
        $this->db->query("DELETE FROM usuario WHERE id = $id");
    }
}
?>