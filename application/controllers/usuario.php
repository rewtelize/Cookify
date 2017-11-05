<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Usuario extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
        $this->load->model('receta','',TRUE);
        $this->load->model('seguimiento','',TRUE);
        $this->load->helper(array('form','url'));
        $this->load->library("pagination");
    }

    function perfil($username)
    {
        $config['upload_path']          = './tmp';
        $config['allowed_types']        = '*';
        $config['max_size']             = 5000;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;
        $this->load->library('upload',$config);

        if($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $id = $this->user->get_id($username);
            $info['lo_sigo'] = 0;
            $info['es_el_mismo'] = 0;
            $info['es_admin'] = 0;
            if($session_data['u'] == $username)
                $info['es_el_mismo'] = 1;
            else if($this->user->es_admin($this->session->userdata('logged_in')['id']))
                $info['es_admin'] = 1;
            else if($this->seguimiento->sigue($session_data['id'],$id))
                $info['lo_sigo'] = 1;

            $info['num_recetas'] = $this->user->get_num_recetas($username)['num'];
            $info['num_siguiendo'] = $this->seguimiento->get_num_siguiendo($id)['num'];
            $info['num_seguidores'] = $this->seguimiento->get_num_seguidores($id)['num'];

            $nuevo = array("u" => "",
                            "p1" => "",
                            "p2" => "",
                            "e1" => "",
                            "e2" => "",
                            "error" => "") ;

            if(isset($_POST))
                if(!is_null($this->input->post("nuevo-nombre")))
                {
                    $nuevo['u'] = $this->input->post("nuevo-nombre");
                    if($this->user->exists($nuevo['u']))
                        $nuevo["error"] = "Nombre de usuario ya registrado";
                    else
                    {
                        $this->user->nuevo_nombre($id,$nuevo['u']);
                        if($info['es_el_mismo'] == 1)
                        {
                            $session_data['u'] = $nuevo['u'];
                            $this->session->set_userdata('logged_in', $session_data);
                        }
                        redirect('index.php/usuario/perfil/'.$nuevo['u']);
                    }
                }
                else if(!is_null($this->input->post("nuevo-password1")))
                {
                    $nuevo['p1'] = $this->input->post("nuevo-password1");
                    $nuevo['p2'] = $this->input->post("nuevo-password2");
                    if($nuevo['p1'] != $nuevo['p2'])
                        $nuevo["error"] = "Las contraseñas no coinciden";
                    else
                        $this->user->nuevo_password($id,$nuevo['p1']);
                }
                else if(!is_null($this->input->post("nuevo-email1")))
                {
                    $nuevo['e1'] = $this->input->post("nuevo-email1");
                    $nuevo['e2'] = $this->input->post("nuevo-email2");
                    if($nuevo['e1'] != $nuevo['e2'])
                        $nuevo["error"] = "Los emails no coinciden";
                    else if($this->user->exists_email($nuevo['e1']))
                        $nuevo["error"] = "Email ya registrado";
                    else
                    {
                        $this->user->nuevo_email($id,$nuevo['e1']);
                        $session_data = $this->session->userdata('logged_in');
                        $session_data['e'] = $nuevo['e1'];
                        $this->session->set_userdata('logged_in',$session_data);
                        redirect('index.php/usuario/perfil/'.$session_data['u']);
                    }
                }  
                else if($this->upload->do_upload('pp-picture'))
                {
                    $this->user->nueva_foto($id,file_get_contents($this->upload->data('full_path')));
                    $session_data = $this->session->userdata('logged_in');
                    $session_data['pp'] = file_get_contents($this->upload->data('full_path'));
                    $this->session->set_userdata('logged_in',$session_data);
                }

            
            $config = array();
            include("pagination_bootstrap.php");
            $config["per_page"] = 4;
            $config["uri_segment"] = 4;
            $config["base_url"] = base_url() . "index.php/usuario/perfil/$username";
            $config["total_rows"] = count($this->receta->get_recetas(array($id)));

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $this->load->view('perfil_view', 
                    array('perfil_info' => $this->user->get_user_info_by_username($username),
                          'recetas' => $this->receta->get_recetas(array($id), $config["per_page"], $page),
                          'info' => $info,
                          'nuevo' => $nuevo,
                          'links' => $this->pagination->create_links()) 
                    );
        }
        else
            //If no session, redirect to login page
            redirect('', 'refresh');
    }

    function ver_siguiendo($page=0,$username=-1)
    {
        if($username == -1)
            $array_siguiendo = $this->seguimiento->get_siguiendo($this->session->userdata('logged_in')['id']);
        else
            $array_siguiendo = $this->seguimiento->get_siguiendo($this->user->get_id($username));

        $data = array();
        $i = 0;
        foreach ($array_siguiendo as $k => $v) 
        {
            $data[$i] = $this->user->get_user_info_by_id($v['id_siguiendo']);
            $data[$i]['num_recetas'] = $this->user->get_num_recetas($data[$i]['nombre'])['num'];
            $data[$i]['num_seguidores'] = $this->seguimiento->get_num_siguiendo($v['id_siguiendo'])['num'];
            $data[$i]['num_siguiendo'] = $this->seguimiento->get_num_seguidores($v['id_siguiendo'])['num'];
            $i++;
        }

        $config = array();
        include("pagination_bootstrap.php");
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["base_url"] = base_url() . "index.php/usuario/ver_siguiendo";
        $config["total_rows"] = count($array_siguiendo);

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $this->load->view('ver_usuarios_view', 
                array('usuarios' => $data,
                      'links' => $this->pagination->create_links()) 
                );


        //var_dump($data);
    }

    function ver_seguidores($page=-1,$username=-1)
    {
        if($username == -1)
        {
            $array_siguiendo = $this->seguimiento->get_seguidores($this->session->userdata('logged_in')['id']);
        }
        else
        {
            $array_siguiendo = $this->seguimiento->get_seguidores($this->user->get_id($username));
        }
        $data = array();
        $i = 0;
        foreach ($array_siguiendo as $k => $v) 
        {
            $data[$i] = $this->user->get_user_info_by_id($v['id_seguidor']);
            $data[$i]['num_recetas'] = $this->user->get_num_recetas($data[$i]['nombre'])['num'];
            $data[$i]['num_seguidores'] = $this->seguimiento->get_num_siguiendo($v['id_seguidor'])['num'];
            $data[$i]['num_siguiendo'] = $this->seguimiento->get_num_seguidores($v['id_seguidor'])['num'];
            $i++;
        }

        $config = array();
        include("pagination_bootstrap.php");
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["base_url"] = base_url() . "index.php/usuario/ver_seguidores";
        $config["total_rows"] = count($array_siguiendo);

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $this->load->view('ver_usuarios_view', 
                array('usuarios' => $data,
                      'links' => $this->pagination->create_links()) 
                );


        //var_dump($data);
    }

    function busqueda()
    {
        if(isset($_POST))
        {
            $username = $this->input->post('usuario');
            $this->session->set_userdata('busqueda_usuario', $username);
        }
        else
            $username = $this->session->userdata('busqueda_usuario');


        $config = array();
        include("pagination_bootstrap.php");
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["base_url"] = base_url() . "index.php/usuario/busqueda";
        $config["total_rows"] = count($this->user->busqueda_por_username($username));

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $data = $this->user->busqueda_por_username($username,$config["per_page"],$page);

        $i = 0;
        for($i=0; $i<count($data); $i++) 
        {
            $data[$i]['num_recetas'] = $this->user->get_num_recetas($data[$i]['nombre'])['num'];
            $data[$i]['num_seguidores'] = $this->seguimiento->get_num_siguiendo($data[$i]['id'])['num'];
            $data[$i]['num_siguiendo'] = $this->seguimiento->get_num_seguidores($data[$i]['id'])['num'];
        }

        $this->load->view('ver_usuarios_view', 
                array('usuarios' => $data,
                      'links' => $this->pagination->create_links()) 
                );
    }

    function seguir($username)
    {
        $this->seguimiento->nuevo_seguidor($this->session->userdata('logged_in')['id'],$this->user->get_id($username));
        redirect('index.php/usuario/perfil/'.$username);
    }

    function dejar_de_seguir($username)
    {
        $this->seguimiento->borrar_seguidor($this->session->userdata('logged_in')['id'],$this->user->get_id($username));
        redirect('index.php/usuario/perfil/'.$username);
    }

    function borrar_usuario()
    {
        $username = $this->input->post('usuario');
        $id = $this->user->get_id($username);

        /* Borrar recetas */
        $this->receta->borrar_recetas_de_user($id);

        /* Borrar comentarios hechos */
        $this->receta->borrar_comentarios_de_user($id);

        /* Borrar valoraciones */
        $this->receta->borrar_valoraciones_de_user($id);

        /* Borrar seguimientos */
        $this->seguimiento->borrar_seguimientos_seguidores_de_user($id);

        /* Borrar usuario */
        $this->user->borrar_usuario($id);

        if($id == $this->session->userdata('logged_in')['id'])
        {
            $this->session->unset_userdata('logged_in');
            session_destroy();
            redirect('', 'refresh');
        }
        else
            redirect('index.php/home');
    }
}
?>