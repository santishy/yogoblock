<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('ModelCliente');
		$this->form_validation->set_message('required', '%s es un campo requerido');
		$this->form_validation->set_message('valid_email', '%s No es un email valido');
		$this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
	}
	function vistaCliente()
	{
		$this->load->view('general/header');
		$this->load->view('general/scripts');
		$this->load->view('clientes/cliente');
		$this->load->view('general/footer');
	}	
	function registrarCliente()
	{
		$this->form_validation->set_rules('nombre','Nombre','required|');
		$this->form_validation->set_rules('apellido_paterno','Apellido Paterno','required');
		$this->form_validation->set_rules('apellido_materno','Apellido Materno','required');
		$this->form_validation->set_rules('calle','Calle','required');
		$this->form_validation->set_rules('colonia','Colonia','required');
		$this->form_validation->set_rules('num_ext','Numero Exterior','required');
		$this->form_validation->set_rules('num_int','Numero Interior','required');
		$this->form_validation->set_rules('estado','Estado','required');
		$this->form_validation->set_rules('ciudad','Ciudad','required');
		if($this->form_validation->set_rules()===FALSE)
		{
			$this->vistaCliente();//?????  hay que mandar un parametro para desaparecer Panel Credito
		}
		else
		{
			$data=$this->input->post();
			$

		}

	}

}
?>