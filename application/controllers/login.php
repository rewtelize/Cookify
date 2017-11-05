<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Login extends CI_Controller {

	function __construct()
 	{
   		parent::__construct();
   		$this->load->model('user','',TRUE);
        $this->load->model('receta','',TRUE);
        $this->load->model('seguimiento','',TRUE);
        $this->load->model('ingrediente','',TRUE);
   		$this->load->helper(array('form'));
 	}

 	function index()
 	{
   		if($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $session_data['num_recetas'] = $this->user->get_num_recetas($session_data['u'])['num'];
            $session_data['num_siguiendo'] = $this->seguimiento->get_num_siguiendo($session_data['id'])['num'];
            $session_data['num_seguidores'] = $this->seguimiento->get_num_seguidores($session_data['id'])['num'];
            if( $session_data['num_siguiendo'] != "0")
                $session_data['timeline'] = $this->timeline($this->seguimiento->get_siguiendo($session_data['id']));
            $this->session->set_userdata('logged_in', $session_data);
            redirect('index.php/home');
        }
        else
            $this->load->view('login_view');
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

 	function verify()
    {
        //This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_check_database');
        if($this->form_validation->run() == FALSE)
            //Field validation failed.  User redirected to login page
            $this->load->view('login_view',array('error' => 'Usuario o contraseña incorrectos'));
        else
            //Go to private area
            redirect('index.php/home');
    }

    function check_database($password)
    {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');
        //query the database
        $result = $this->user->login($username, $password);
        //var_dump($result);
        if($result != FALSE)
        {
            $sess_array = array('id' => $result['id'], 'u' => $result['nombre'], 'pp' => $result['foto'], 'e' => $result['email']);
            $this->session->set_userdata('logged_in', $sess_array);
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_database', '');
            return FALSE;
        }
    }
}

?>