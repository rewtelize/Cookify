<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Recetas extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
        $this->load->model('receta','',TRUE);
        $this->load->model('ingrediente','',TRUE);
        $this->load->helper(array('form','url'));
        $this->load->library("pagination");
    }

    function index()
    {
        if($this->session->userdata('logged_in'))
        {
            $this->load->view('nueva_receta_view',array("ingredientes" => $this->ingrediente->get_todos()));
        }
        else
            $this->load->view('login_view');
    }

    function nueva()
    {
        $config['upload_path']          = './tmp';
        $config['allowed_types']        = '*';
        $config['max_size']             = 5000;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;
        $this->load->library('upload',$config);

        $session_data = $this->session->userdata('logged_in');

        $nueva_receta = array('dificultad' => $this->input->post('dificultad'),
                              //'fecha' => $this->input->post('fecha'),
                              'foto' => null,
                              //'id' => $this->input->post('id'),
                              'id_autor' => $session_data['id'],
                              'nombre' => $this->input->post('nombre'),
                              //'num_valoraciones' => 0,
                              'tiempo' => $this->input->post('tiempo'),
                              'tipo' => $this->input->post('tipo'),
                              'ingredientes' => array(),
                              //'valoracion' => 0
                              );

        for($i=0; $i<6; $i++)
                $nueva_receta['ingredientes'][$i] = array('nombre' => $this->input->post("ing-$i-nombre"),
                                                    'cantidad' =>$this->input->post("ing-$i-cantidad"),
                                                    'unidad' => $this->input->post("ing-$i-unidad"));

        if (empty($_FILES['receta-picture']['name']))
            $nueva_receta['foto'] = file_get_contents("./assets/images/bg1.jpg");
        
        else if(!$this->upload->do_upload('receta-picture'))
        {
            $data['error'] = $this->upload->display_errors();
            $this->load->view('nueva_receta_view',$data);
            $upload = false;
        }
        else
            $nueva_receta['foto'] = file_get_contents($this->upload->data('full_path'));

        $id_receta = $this->receta->nueva_receta($nueva_receta);
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }

    function ver_receta($id_receta)
    {
        $datos_view = array();

        $datos_view['ingredientes_receta'] = $this->receta->get_ingredientes($id_receta);
        $datos_view['valoracion'] = $this->receta->valoracion($id_receta,$this->session->userdata('logged_in')['id']);
        $datos_view['pasos'] = $this->receta->get_pasos($id_receta);
        $datos_view['ingredientes'] = $this->ingrediente->get_todos();

        $datos_view['datos_receta'] = $this->receta->get_receta_by_id($id_receta);

        if($datos_view['datos_receta']['id_autor'] == $this->session->userdata('logged_in')['id'] || 
            $this->user->es_admin($this->session->userdata('logged_in')['id']))
            $datos_view['es_autor'] = 1;
        else
            $datos_view['es_autor'] = 0;

        $config = array();
        include("pagination_bootstrap.php");
        $config["per_page"] = 4;
        $config["uri_segment"] = 4;
        $config["base_url"] = base_url() . "index.php/recetas/ver_receta/$id_receta";

        /*
         * Funcion de receta get_comentarios(id_receta)  
         */ 
        $config["total_rows"] = count($this->receta->get_comentarios($id_receta));

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $datos_view['comentarios'] = $this->receta->get_comentarios($id_receta,$config['per_page'],$page);
        //$datos_view['comentarios'] = array(1,2,3);
        $datos_view['links'] = $this->pagination->create_links();
        //var_dump($datos_view['comentarios']);
        $this->load->view("ver_receta_view",$datos_view);

    }

    function nuevo_ingrediente($id_receta)
    {
        $datos_ingrediente = $this->input->post('nuevo-ingrediente');
        $datos_ingrediente[0] = $this->receta->get_id_ingrediente($datos_ingrediente[0]);
        $datos_ingrediente[3] = $id_receta;
        $this->receta->insertar_ingrediente($datos_ingrediente);
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }

    function borrar_ultimo_ingrediente($id_receta)
    {
        $this->receta->borrar_ingrediente($id_receta);
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }

     function nuevo_paso($id_receta)
    {
        $this->receta->insertar_paso(array($id_receta, $this->input->post('paso-desc')));
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }

    function borrar_ultimo_paso($id_receta)
    {
        $this->receta->borrar_paso($id_receta);
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }

    function borrar_receta($id_receta)
    {
        $this->receta->borrar_receta($id_receta);
        redirect('/');
    }

    function editar_receta($id_receta)
    {
        $config['upload_path']          = './tmp';
        $config['allowed_types']        = '*';
        $config['max_size']             = 5000;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;
        $this->load->library('upload',$config);


        $nueva_receta = array('dificultad' => $this->input->post('dificultad'),
                              'id' => $id_receta,
                              'foto' => null,
                              'nombre' => $this->input->post('nombre'),
                              'tiempo' => $this->input->post('tiempo'),
                              'tipo' => $this->input->post('tipo'),
                              );

        if($this->upload->do_upload('receta-picture'))
            $nueva_receta['foto'] = file_get_contents($this->upload->data('full_path'));

        $this->receta->actualizar_receta($nueva_receta);
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }

    function ver_recetas($username=-1)
    {
        if($username!=-1)
            redirect("index.php/recetas/busca_recetas/0/$username");
        else
            redirect('index.php/recetas/busca_recetas/0/'.$this->session->userdata('logged_in')['u']);
    }

    function busca_recetas($page=0,$autor="")
    {
        if($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $filtros = array('autor' => $this->input->post('autor'),
                            'nombre' => $this->input->post('nombre'),
                            'ingredientes' => $this->input->post('ingredientes'),
                            'tmp-max' => $this->input->post('tmp-max'),
                            'val_min' => $this->input->post('val_min'),
                            'val_max' => $this->input->post('val_max'),
                            'dificultad_f' => $this->input->post('dificultad_facil'),
                            'dificultad_m' => $this->input->post('dificultad_media'),
                            'dificultad_d' => $this->input->post('dificultad_dificil'),
                            'tipo' => $this->input->post('tipo'));
            $this->session->set_userdata('filtros', $filtros);
        }   
        else if($autor != "")
        {
            $filtros = array('autor' => $autor,
                            'nombre' => null,
                            'ingredientes' => null,
                            'tmp-max' => '120',
                            'val_min' => '1',
                            'val_max' => '5',
                            'dificultad_f' => '1',
                            'dificultad_m' => '2',
                            'dificultad_d' => '3',
                            'tipo' => '');
            $this->session->set_userdata('filtros', $filtros);
        }
        else
            $filtros = $this->session->userdata('filtros');

        $recetas_encontradas = null;

        $config = array();
        include("pagination_bootstrap.php");
        $config["per_page"] = 4;
        $config["uri_segment"] = 3;
        $config["base_url"] = base_url() . "index.php/recetas/busca_recetas";
        $config["total_rows"] = count($this->receta->filtrado($filtros,-1,-1));

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->receta->filtrado($filtros, $config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        $this->load->view("busqueda_receta_view", $data);
    }

    function nuevo_comentario($id_receta)
    {
        $this->receta->nuevo_comentario($id_receta, 
                                    $this->session->userdata('logged_in')['id'], 
                                    $this->input->post('nuevo-comentario'));
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }

    function borrar_comentario($id_receta, $id_comentario)
    {
        $this->receta->borrar_comentario($id_receta, $id_comentario);
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }

    function valorar($id_receta)
    {
        $this->receta->valorar($id_receta, $this->session->userdata('logged_in')['id'], $this->input->post('valoracion'));
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }

    function borrar_valoracion($id_receta)
    {
        $this->receta->borrar_valoracion($id_receta, $this->session->userdata('logged_in')['id']);
        redirect('index.php/recetas/ver_receta/'.$id_receta);
    }


    

}
?>