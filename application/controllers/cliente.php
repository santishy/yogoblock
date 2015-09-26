<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('ModelCliente');
		$this->form_validation->set_message('required', '%s es un campo requerido');
		$this->form_validation->set_message('valid_email', '%s No es un email valido');
		$this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
	}
	function vistaCliente()
	{
		if($this->session->userdata('id_cliente') && $this->session->userdata('id_venta'))
			redirect(base_url().'pedido/frmpedido');
		$data['ban']=1;
		if($this->session->userdata('id_venta'))
			$data['ban']=0;
		$this->load->view('general/header',$data);
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
		if($this->form_validation->run()===FALSE)
		{
			$this->vistaCliente();//?????  hay que mandar un parametro para desaparecer Panel Credito
		}
		else
		{
			$data=$this->input->post();
			$query=$this->ModelCliente->comprobarCliente($data);
			if($query->num_rows()==0)
			{
				$query=$this->ModelCliente->insertarCliente($data);	
				$query=$this->ModelCliente->comprobarCliente($data);
			}
			$vec=$query->row_array();
			$this->session->set_userdata('id_cliente',$vec['id_cliente']);
			redirect(base_url().'pedido/frmPedido');
		}

	}
	function vistaPedido()
	{
		$data['ban']=0;
		if($this->session->userdata('id_pedido'))
			$data['ban']=1;
		$this->load->view('general/header',$data);
		$this->load->view('general/scripts');
		$this->load->view('pedidos/frmpedido');
		$this->load->view('general/footer');
	}
	function lista()
	{
		//$query=$this->ModelCliente->getVentas();
		$uri_segment=3;
		$offset=$this->uri->segment($uri_segment);	
		if(empty($offset))
			$offset=0;
		$config['base_url']=base_url().'cliente/lista';
		$config['total_rows']=$this->ModelCliente->numClientes();
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
		$data['cont']=$this->uri->segment($uri_segment);
		$data['query']=$this->ModelCliente->getClientes($offset,$config['per_page']);
		$data['num']=$config['total_rows'];
		$this->load->view('general/header',$data);
		$this->load->view('general/scripts');
		$this->load->view('clientes/lista');
		$this->load->view('general/footer');
	}
	

}
?>