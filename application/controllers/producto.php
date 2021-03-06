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
	function crearVarCliente()
	{
		$this->session->set_userdata('id_cliente',$this->input->post('id_cliente'));
		redirect(base_url().'producto/allproductos');
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
		$this->form_validation->set_rules('medida','Medida','required');
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
	function sessionCart()
	{
		$op=$this->input->post('op');
		if($op=="c")
		{
			if(!$this->session->userdata('carrito'))
			{
				$this->session->set_userdata('carrito','compras');
				$this->insertarCarrito($this->input->post());
			}
			else
			{
				if($this->session->userdata('carrito')!='compras')
				{
					$data['ban']=2;
					echo json_encode($data);	
				}
				else
					$this->insertarCarrito($this->input->post());	
			}
		}
		else
		if($op=="v")
		{	
			if(!$this->session->userdata('carrito'))
			{
				$this->session->set_userdata('carrito','ventas');
				$this->insertarVenta($this->input->post());
			}
			else
			{
				if($this->session->userdata('carrito')!='ventas')
				{
					$data['ban']=2;
					echo json_encode($data);	
				}
				else
				{
					$this->insertarVenta($this->input->post());				
				}
			}
		}
		else
			{
				$data['ban']=20;
				echo json_encode($data);	
			}
	}
	function insertarCarrito($data)
	{
		$datos=$this->input->post();
		$ban=$this->validarEmpty($datos);
		if($ban)
		{
			$this->session->set_userdata('fecha_compra',$datos['fecha_compra']);
			$id_producto=$data['id_producto'];
			$cant=$data['cant_compra'];
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
				'price'=>$data['precio_compra'],
				'name'=>$data['nombre_producto'],
				'fecha_compra'=>$data['fecha_compra'],
				'categoria'=>$data['categoria']
				);
			$this->cart->insert($data);
			$data['ban']=1;
			$data['total']=$this->cart->total_items();
		}
		else
			$data['ban']=0;
		echo json_encode($data);
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
		$this->session->unset_userdata('compras');
		$this->cart->destroy();
		$this->session->unset_userdata('carrito');
		$this->allproductos();
	}
	function verCarrito()
	{
		$data['funcion']="producto/terminarCompra";
		$data['movimiento']="COMPRAS";
		$data['nameLink']="Comprar";
		$this->vistaCart($data);
	}
	function verCarritoV()
	{
		$data['funcion']="cliente/vistaCliente";
		$data['movimiento']="VENTAS";
		$data['nameLink']="Vender";
		$this->vistaCart($data);
	}
	function vistaCart($data)
	{
		$this->load->view('general/header',$data);
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
		$this->session->unset_userdata('carrito');
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
	function insertarVenta($datos)
	{
		//if($this->session->)
		//$datos=$this->input->post();
		$ban=$this->validarEmpty($datos);
		if($ban)
		{
			$query=$this->ModelProducto->getProducto($datos['id_productoV']);
			if($query->num_rows()>0)
				$vec=$query->row_array();
			if(isset($vec['existencia']))
				if($vec['existencia']<$datos['cant_venta'])
					$data['ban']=3;
				else
				{
					$this->session->set_userdata('fecha_venta',$datos['fecha_venta']);
					$id_producto=$datos['id_productoV'];
					$cant=$datos['cant_venta'];
					$id_precio=$datos['id_precio'];
					$query=$this->ModelProducto->getPrecio($id_precio);
					foreach ($query->result() as $row)
					{
						$pv=$row->precio;
						$datos['id_precio']=$row->id;
					}
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
						'price'=>$pv,
						'name'=>$datos['name'],
						'fecha_venta'=>$datos['fecha_venta'],
						'categoria'=>$datos['categoria'],
						'id_precio'=>$datos['id_precio'],
						//'credito'=>$datos['credito']
						);
					$this->cart->insert($data);
					$data['ban']=1;
					$data['total']=$this->cart->total_items();
				}
				else
					$data['ban']=0;
			}
		echo json_encode($data);
	}
	function comprobarProducto()
	{
		$medida=$this->input->post('medida');
		$nombre_producto=$this->input->post('nombre_producto');
		$id_categoria=$this->input->post('id_categoria');
		$query=$this->ModelProducto->comprobarProducto($medida,$nombre_producto,$id_categoria);
		if($query->num_rows>0)
		{
			$this->form_validation->set_message('comprobarProducto','Ya existe un producto con esas caracteristicas');
			return false;
		}
		else
		{
			return true;
		}
	}
	function terminarVenta()
	{
		$entro=false;
		$credito=$this->input->post('credito');
		$data['credito']=$credito;
		$data['fecha_venta']=$this->session->userdata('fecha_venta');
		$query=$this->ModelProducto->insertarVenta($data);
		$query=$this->ModelProducto->maxIdVenta();
		foreach ($query->result() as $row) 
		{
			$id_venta=$row->id_venta;
			$this->session->set_userdata('id_venta',$id_venta); // comprobar fallas al regresar de clientes para otra parte .. etc
		}
		if(isset($id_venta))
		{
			$i=0;
			foreach ($this->cart->contents() as $item) 
			{
				$arr['id_venta']=$id_venta;
				$arr['cantidad_venta']=$item['qty'];
				$arr['id_producto']=$item['id'];
				$arr['id_precio']=$item['id_precio'];
				$arr['precio']=$item['price'];
				$ban[$i++]=$this->ModelProducto->vender($arr);// regresa banderas del procedure		
			}
			$json['banderas']=$ban;
			$json['ban']=1;
			if($this->session->userdata('id_cliente'))
				$json['cliente']=1;
			else
				$json['cliente']=0;
			$this->cart->destroy();
			if($this->session->userdata('fecha_venta'))
				$this->session->unset_userdata('fecha_venta');
			$this->session->unset_userdata('carrito');	
			echo json_encode($json);
		}	
		else
		{
			$json['ban']=0;
			echo json_encode($json);
		}	
	}
	#checa si la variable carrito existe.------------------------------------------------------------
	function activarLink()
	{
		if($this->session->userdata('carrito'))
		{
			$data['ban']=1;
			if($this->session->userdata('carrito')=="compras")
			{
				$data['url']=base_url().'producto/vercarrito';
				$data['urlSig']=base_url().'producto/terminarCompra';
			}
			elseif ($this->session->userdata('carrito')=="ventas")
			{
				$data['url']=base_url().'producto/verCarritoV';
				$data['urlSig']=base_url().'cliente/vistaCliente';
			}
				
		}
		else
		{
			$data['ban']=2;
			$data['url']="#";
		}
		echo json_encode($data);
	}
}
?>