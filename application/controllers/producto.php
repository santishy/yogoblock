<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelProducto');
		$this->load->library('pagination');
		$this->form_validation->set_message('required', '%s es un campo requerido');
		$this->form_validation->set_message('valid_email', '%s No es un email valido');
		$this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
	}
	public function index()
	{
		
	}
	function allproductos()
	{
		$uri_segment=3;
		$offset=$this->uri->segment($uri_segment);	
		if(empty($offset))
			$offset=0;
		$config['base_url']=base_url().'productos/allproductos';
		$config['total_rows']=$this->ModelProducto->numRowsProductos();
		$config['per_page']=50;
		$connfig['num_links']=5;
		$config['first_link']="Primero";
		$config['last_link']="Ultimo";
		$config['next_link']=">>";
		$config['prev_link']="<<";
		$config['cur_tag_open']="<span class='badge'>";
		$config['cur_tag_close']="</span>";
		$config['uri_segment']=$uri_segment;
		$this->pagination->initialize($config);
		$data['paginacion']=$this->pagination->create_links();
		//$data['query']->next_result();
		$data['cont']=$this->uri->segment($uri_segment);
		$data['ruta']="salidaservicio.js";
		$data['query']=$this->ModelProducto->getCategorias();
		$data['productos']=$this->ModelProducto->getProductos($offset,$config['per_page']);
		$data['num']=$config['total_rows'];
		$this->load->view('general/header',$data);
		$this->load->view('productos/allproductos');
		$this->load->view('general/scripts');
		$this->load->view('productos/modales');
		$this->load->view('general/footer');
	}
	function agregarProducto()
	{
		$this->form_validation->set_rules('nombre_producto','Nombre del Producto','required|trim|callback_comprobarProducto');
		$this->form_validation->set_rules('precio_compra','Precio de compra','required|trim');
		$this->form_validation->set_rules('id_categoria','Categoria','required|trim');
		$this->form_validation->set_rules('descripcion','Descripcion','required|trim');
		if($this->form_validation->run()==false)
		{
			$this->allproductos();
		}
		else
		{
			$data=$this->input->post();
			$query=$this->ModelProducto->agregarProducto($data);
			$this->allproductos();
		}
	}
}
?>