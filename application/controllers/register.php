<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Register extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
    }

    function index()
    {
        $this->load->helper(array('form'));
        $this->load->view('register_view');
    }
    

    function newuser()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password2', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email2', 'Password', 'trim|required|xss_clean');

        $data = array('u' => $this->input->post('username'),
                        'p' => $this->input->post('password'),
                        'p2' => $this->input->post('password2'),
                        'e' => $this->input->post('email'),
                        'e2' => $this->input->post('email2'));

        $config['upload_path']          = './tmp';
        $config['allowed_types']        = '*';
        $config['max_size']             = 5000;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;

        $upload=true;
        $default=false;
        $this->load->library('upload', $config);
        if (empty($_FILES['profile-picture']['name']))
        { 
            $image_data = file_get_contents("./assets/images/default-pp.png");
            $default=true;
        }

        else if(!$this->upload->do_upload('profile-picture'))
        {
            $data['error'] = $this->upload->display_errors();
            $this->load->view('register_view',$data);
            $upload = false;
        }

        if($data['p'] != $data['p2'])
        {
            $data['error'] = 'Las contraseñas no coinciden';
            $this->load->view('register_view',$data);
        }
        else if($data['e'] != $data['e2'])
        {
            $data['error'] = 'Los emails no coinciden';
            $this->load->view('register_view',$data);
        }
        else if($this->user->exists($data['u']) == TRUE)
        {
            $data['error'] = 'Nombre de usuario ya registrado';
            $this->load->view('register_view',$data);
        }
        else if($this->user->exists_email($data['e']) == TRUE)
        {
            $data['error'] = 'E-mail ya registrado';
            $this->load->view('register_view',$data);
        }
        else if($upload)
        {
            if(!$default) $image_data = file_get_contents($this->upload->data('full_path'));
            $data['pp'] = $image_data;
            $this->user->save($data);
            $this->session->set_userdata('logged_in', $data);
            $this->load->view('register_success_view', $data);
        }
    }

}
?>