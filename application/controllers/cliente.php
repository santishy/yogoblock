<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('ModelProducto');
		$this->form_validation->set_message('required', '%s es un campo requerido');
		$this->form_validation->set_message('valid_email', '%s No es un email valido');
		$this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
	}
	function frmCliente()
	{
		$this->load->view('general/header');
		$this->load->view('clientes/cliente');
		$this->load->view('general/scripts');
		$this->load->view('general/footer');
	}	
}
?>