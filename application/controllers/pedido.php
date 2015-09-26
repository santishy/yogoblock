<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller 
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
	function frmPedido()
	{
		$data['ban']=0;
		if($this->session->userdata('id_pedido'))
			$data['ban']=1;
		$data['query']=$this->ModelCliente->getDestinos($this->session->userdata('id_cliente'));
		$this->load->view('general/header',$data);
		$this->load->view('general/scripts');
		$this->load->view('pedidos/frmpedido',$data);
		$this->load->view('general/footer');
	}
	function addPedido()
	{
		$data=$this->input->post();
		$json['validacion']=$this->validarEmpty($data);
		if($json['validacion'])
		{
			$data['id_cliente']=$this->session->userdata('id_cliente');
			$data['id_venta']=$this->session->userdata('id_venta');
			if(isset($data['id_cliente'])and isset($data['id_venta']))  
			{
				$query=$this->ModelCliente->addPedido($data);
				$json['ban']=$query;
				$query=$this->ModelCliente->getMaxId();
				foreach ($query->result() as $row) 
				{
					$this->session->set_userdata('id_pedido',$row->id_pedido);
				}
			}
			else
				$json['ban']=0; // no existe 	
		}
		$vec=$this->comprobarIdDestinoPedido($json);
		echo json_encode($vec);	
	}
	function comprobarIdDestinoPedido($json)
	{
		$json['id_pedido']=0;
		$json['id_destino']=0;
		if($this->session->userdata('id_pedido'))
			$json['id_pedido']=1;
		if($this->session->userdata('id_destino'))
			$json['id_destino']=1;
		return $json;
	}
	function addDestino()
	{
		$data=$this->input->post();
		$json['validacion']=$this->validarEmpty($data);
		if($json['validacion'])
		{
			$data['id_cliente']=$this->session->userdata('id_cliente');
			$query=$this->ModelCliente->comprobarDestino($data);
			if($query->num_rows()==0)
			{
				$query=$this->ModelCliente->addDestino($data);
				$query=$this->ModelCliente->maxIdDestino();
				if($query->num_rows()>0)
					$row=$query->row_array();
				$this->session->set_userdata('id_destino',$row['id_destino']);
				$json['ban']=1;
			}
			else
			{
				$row=$query->row_array();
				$query=$this->ModelCliente->comprobarDet_dest_ped($row['id_destino'],$this->session->userdata('id_pedido'));
				if($query->num_rows()>0)
					$json['ban']=2;
				else
				{
					$query=$this->ModelCliente->addDet_dest_ped($row['id_destino'],$this->session->userdata('id_pedido'));//comprobar 
					$json['ban']=1;
				}
			}
			
		}
		echo json_encode($json);
	}
	function validarEmpty($data)
	{
		if(empty($data))
			$ban=false;
		else
			$ban=true;
		foreach($data as $key => $value) 
		{
			if(empty($data[$key]))
			{
				$ban=false;
				continue;
			}
		}
		return $ban;
	}
	function getDestino()
	{
		$id=$this->input->post('id_destino');
		$query=$this->ModelCliente->getDestino($id);
		echo json_encode($query->result());
	}
	function getDestinos()
	{
		$id=$this->input->post('id_pedido');
		$query=$this->ModelCliente->getDestinos2($id);
		echo json_encode($query->result());
	}
	function buscarEstado()
	{
		$estado=$this->uri->segment(3);
		if($estado=='')
			$estado="pendiente";
		$this->session->set_userdata('estado',$estado);
		redirect(base_url().'pedido/listaPedido');
	}
	function listaPedido()
	{
		$this->session->unset_userdata('id_venta');
		$this->session->unset_userdata('id_cliente');
		$this->session->unset_userdata('id_pedido');
		if($this->session->userdata('id_destino'))
			$this->session->unset_userdata('id_destino');
		//$query=$this->ModelCliente->getVentas();
		$uri_segment=3;
		$offset=$this->uri->segment($uri_segment);	
		if(empty($offset))
			$offset=0;
		$config['base_url']=base_url().'pedido/listaPedido';
		$config['total_rows']=$this->ModelCliente->numVentas($this->session->userdata('estado'));
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
		$data['query']=$this->ModelCliente->getVentas($offset,$config['per_page'],$this->session->userdata('estado'));
		$data['num']=$config['total_rows'];
		$data['estado']=$this->session->userdata('estado');
		$this->load->view('general/header',$data);
		$this->load->view('general/scripts');
		$this->load->view('pedidos/lista');
		$this->load->view('general/footer');
	}
	function mostrarBusqueda($query)
	{
		$data['estado']='';
		$data['paginacion']='';
		$data['query']=$query;
		$this->load->view('general/header',$data);
		$this->load->view('general/scripts');
		$this->load->view('pedidos/lista');
		$this->load->view('general/footer');
	}
	function buscar()
	{
		$clave=$this->input->post('clave');
		$temp=$this->input->post('clave');
		if(ctype_digit($clave))
		{
			$query=$this->ModelCliente->buscarNota($clave);
			$this->mostrarBusqueda($query);
		}
		else 
			{
				$query=$this->ModelCliente->buscarNotaNombre($temp);
				$this->mostrarBusqueda($query);
			}
	}
	function cambiarEstado()
	{
		$data['estado']=$this->uri->segment(3);
		$id=$this->uri->segment(4);
		$this->ModelCliente->cambiarEstado($id,$data);
		$this->session->set_userdata('estado',$data['estado']);
		redirect(base_url().'pedido/listaPedido');
	}
}