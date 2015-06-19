<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria extends CI_Controller 
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
	public function index()
	{
		
	}
	public function vistaAgregarCategoria()
	{
		$this->load->view('general/header');
		$this->load->view('productos/categorias');
		$this->load->view('general/footer');
	}
	public function agregarCategoria()
	{
		$this->form_validation->set_rules('categoria','Categoria','requerid|callback_comprobarCategoria');
		if($this->form_validation->run()===false)
		{
			$this->vistaAgregarCategoria();
		}
		else
		{
			$categoria['categoria']=strtoupper($this->input->post('categoria'));
			$query=$this->ModelProducto->agregarCategoria($categoria);
			echo $query;
		}
	}
	public function comprobarCategoria($str)
	{
		$query=$this->ModelProducto->getCategoria($str);
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('comprobarCategoria','La categoria %s , ya existe');
			return false;
		}
		else
		{
			return true;
		}
	}
}
?>