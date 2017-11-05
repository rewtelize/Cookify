<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
        $this->load->model('receta','',TRUE);
        $this->load->model('seguimiento','',TRUE);
        $this->load->model('ingrediente','',TRUE);
    }

    function index()
    {
        if($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $session_data['num_recetas'] = $this->user->get_num_recetas($session_data['u'])['num'];
            $session_data['id'] = $this->user->get_id($session_data['u']);
            $session_data['num_siguiendo'] = $this->seguimiento->get_num_siguiendo($session_data['id'])['num'];
            $session_data['num_seguidores'] = $this->seguimiento->get_num_seguidores($session_data['id'])['num'];
            $timeline = array();
            if( $session_data['num_siguiendo'] != "0")
               $timeline = $this->timeline($this->seguimiento->get_siguiendo($session_data['id']));
            $this->session->set_userdata('logged_in', $session_data);
            $this->load->view('home_view',array('timeline'=> $timeline));
        }
        else
            //If no session, redirect to login page
            redirect('', 'refresh');
        
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('', 'refresh');
    }

    function timeline($siguiendo)
    {
        $id_siguiendo = array();
        foreach ($siguiendo as $p => $autor) 
            array_push($id_siguiendo, $autor['id_siguiendo']);

        $recetas = $this->receta->get_recetas($id_siguiendo,10);

        foreach ($recetas as $k => $v) 
           $recetas[$k]['nombre_autor'] = $this->user->get_username($v['id_autor']);

        return $recetas;
    }
}

?>