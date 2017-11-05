<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class ForgotPassword extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('user','',TRUE);
    }

    function index()
    {
        echo "Hola, he olvidado la contraseña";
    }

}
?>