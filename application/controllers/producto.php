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
		$this->load->library('cart');
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
		date_default_timezone_set('America/Monterrey');
		$data['fecha_compra']=date('Y-m-d H:i:s'); 
		$data['num']=$config['total_rows'];
		$data['items']=$this->cart->total_items();
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
	// ----------------Carrito de Compras ----------------------------------------------------
	function insertarCarrito()
	{
		//if($this->session->)
		$datos=$this->input->post();
		$ban=$this->validarEmpty($datos);
		if($ban)
		{
			$this->session->set_userdata('fecha_compra',$datos['fecha_compra']);
			$id_producto=$this->input->post('id_producto');
			$cant=$this->input->post('cant_compra');
			foreach ($this->cart->contents() as $item)
			{
				if($id_producto==$item['id'])
				{
					$cant=$item['qty']+$cant;
				}
			}
			$data=array(
				'id'=>$id_producto,
				'qty'=>$cant,
				'price'=>$this->input->post('precio_compra'),
				'name'=>$this->input->post('nombre_producto'),
				'fecha_compra'=>$this->input->post('fecha_compra'),
				'categoria'=>$this->input->post('categoria')
				);
			$this->cart->insert($data);
			echo $this->cart->total_items();
		}
		else
			echo 0;
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
	function terminarCompra()
	{
		if($this->session->userdata('fecha_compra'))
		{

			$this->ModelProducto->compra($this->session->userdata('fecha_compra'));
			$query=$this->ModelProducto->maxIdCompras();
			foreach ($query->result() as $row) 
			{
				$id_compra=$row->id_compra;
			}
			foreach($this->cart->contents() as $item) 
			{

				$data['id_compra']=$id_compra;
				$data['cant']=$item['qty'];
				$data['id_producto']=$item['id'];
				$data['precio']=$item['price'];
				$query=$this->ModelProducto->agregarCompra($data);
			}
		}
		$this->session->unset_userdata('fecha_compra');
		$this->cart->destroy();
		$this->allproductos();
	}
	function verCarrito()
	{
		$this->load->view('general/header');
		$this->load->view('productos/vercarrito');
		$this->load->view('general/scripts');
		$this->load->view('general/footer');
	}
	function updateCompras()// recordar que al dejar en cero carrito hay q borrar posible session
	{
		$data=$this->input->post();
		$this->cart->update($data);
		redirect(base_url().'producto/verCarrito');
	}
	function destruirCompras()
	{
		if($this->session->userdata('fecha_compra'))
			$this->session->unset_userdata('fecha_compra');
		$this->cart->destroy();
		redirect(base_url().'producto/allproductos');
	}
	#agregar precios de ventas
	function agregarPrecio()
	{
		$data=$this->input->post();
		$ban=$this->validarEmpty($data);
		if($ban)
		{
			$query=$this->ModelProducto->agregarPrecio($data);
			echo $query;
		}
		else
			echo 0;
	}
	function getPrecios()
	{
		$id_producto=$this->input->post('id_producto');
		$query=$this->ModelProducto->getPrecios($id_producto);
		echo json_encode($query->result());
	}
	//----------------------------------VENTAS--------------------------------------------------
	function insertarVenta()
	{
		//if($this->session->)
		$datos=$this->input->post();
		$ban=$this->validarEmpty($datos);
		if($ban)
		{
			$this->session->set_userdata('fecha_compra',$datos['fecha_compra']);
			$id_producto=$this->input->post('id_producto');
			$cant=$this->input->post('cant_compra');
			foreach ($this->cart->contents() as $item)
			{
				if($id_producto==$item['id'])
				{
					$cant=$item['qty']+$cant;
				}
			}
			$data=array(
				'id'=>$id_producto,
				'qty'=>$cant,
				'price'=>$this->input->post('precio_compra'),
				'name'=>$this->input->post('nombre_producto'),
				'fecha_venta'=>$this->input->post('fecha_compra'),
				'categoria'=>$this->input->post('categoria')
				);
			$this->cart->insert($data);
			echo $this->cart->total_items();
		}
		else
			echo 0;
	}
}
?>