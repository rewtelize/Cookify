<?php
Class Seguimiento extends CI_Model
{
    function get_siguiendo($id_user)
    {
    	return $this->db->query("SELECT id_siguiendo FROM Seguimiento WHERE id_seguidor=$id_user")->result_array();
    }

    function sigue($id_seguidor, $id_siguiendo)
    {
        if(empty($this->db->query("SELECT * FROM Seguimiento WHERE id_seguidor=$id_seguidor AND id_siguiendo=$id_siguiendo")->result_array()))
            return false;
        else
            return true;
    }

    function get_num_siguiendo($id_user)
    {
    	return $this->db->query("SELECT count(id_siguiendo) as num FROM Seguimiento WHERE id_seguidor=$id_user")->result_array()[0];
    }

    function get_num_seguidores($id_user)
    {
    	return $this->db->query("SELECT count(id_seguidor) as num FROM Seguimiento WHERE id_siguiendo=$id_user")->result_array()[0];
    }

    function get_seguidores($id_user)
    {
        return $this->db->query("SELECT id_seguidor FROM Seguimiento WHERE id_siguiendo=$id_user")->result_array();
    }

    function nuevo_seguidor($id_seguidor, $id_seguido)
    {
        $this->db->query("INSERT INTO seguimiento (id_seguidor,id_siguiendo) VALUES ($id_seguidor, $id_seguido)");
    }

    function borrar_seguidor($id_seguidor, $id_seguido)
    {
        $this->db->query("DELETE FROM seguimiento WHERE id_seguidor=$id_seguidor AND id_siguiendo=$id_seguido");
    }

    function borrar_seguimientos_seguidores_de_user($id)
    {
        $this->db->query("DELETE FROM seguimiento WHERE id_seguidor=$id OR id_siguiendo=$id");
    }
}
?>