<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelProducto extends CI_Model {
	function __construct ()
	{
		parent::__construct();
	}
	function agregarCategoria($data)
	{
		$query=$this->db->insert('categorias',$data);
		return $query;
	}
	function getCategoria($categoria)
	{
		$this->db->where('categoria',$categoria);
		$query=$this->db->get('categorias');
		return $query;
	}
	function getCategorias()
	{
		$this->db->select('*');
		$query=$this->db->get('categorias');
		return $query;
	}
	function numRowsProductos()
	{
		$query=$this->db->query('select count(id_producto) as num from productos where activo=1');
		$num=0;
		foreach ($query->result() as $row) 
		{
			$num=$row->num;
		}
		return $num;
	}
	function getProductos($uri,$tope)
	{
		$query=$this->db->query('select *from productos p join categorias c on p.id_categoria=c.id_categoria where activo=1 limit '.$uri.','.$tope.';');
		return $query;
	}
	function agregarProducto($data)
	{
		$query=$this->db->insert('productos',$data);
		return $query;
	}
	function compra($fecha)
	{
		$data['fecha_compra']=$fecha;
		$query=$this->db->insert('compras',$data);
		return $query;
	}
	function maxIdCompras()
	{
		$this->db->select_max('id_compra');
		$query=$this->db->get('compras');
		return $query;
	}
	function agregarCompra($data)
	{
		$query=$this->db->query('call agregarCompra('.$data['id_compra'].','.$data['id_producto'].','.$data['cant'].','.$data['precio'].',@ban);');
		$query->next_result();
		$query=$this->db->query('SELECT @ban');
		foreach ($query->result_array() as $row) 
		{
			$ban=$row['@ban'];
		}
		return $ban;
	}
	function agregarPrecio($data)
	{
		$query=$this->db->query('call agregarPrecio('.$data['id_producto'].',"'.$data['tipo'].'",'.$data['precio'].',@ban);');
		$query->next_result();
		$query=$this->db->query('SELECT @ban');
		foreach ($query->result_array() as $row) 
		{
			$ban=$row['@ban'];
		}
		return $ban;
	}
	function getPrecios($id)
	{
		$query=$this->db->query('select p.id_precio,p.tipo,p.precio from productos pr join det_precios_ventas d on pr.id_producto=d.id_producto join precios p on d.id_precio=p.id_precio where d.id_producto='.$id.';');
		return $query;
	}
	function getPrecio($id_precio)
	{
		$this->db->where('precios.id_precio',$id_precio);
		$this->db->from('precios');
		$this->db->join('det_precios_ventas','precios.id_precio=det_precios_ventas.id_precio');
		$query=$this->db->get();
		return $query;
	}
	function comprobarProducto($medida,$nombre_producto,$id_categoria)
	{
		$this->db->where('medida',$medida);
		$this->db->where('nombre_producto',$nombre_producto);
		$this->db->where('id_categoria',$id_categoria);
		$query=$this->db->get('productos');
		return $query;
	}
	//ventas------------------------------------------------------------------
	function insertarVenta($data)
	{
		$query=$this->db->insert('ventas',$data);
		return $query;
	}
	function maxIdVenta()
	{
		$query=$this->db->query('select max(id_venta) as id_venta from ventas');
		return $query;
	}
	function getProducto($id)
	{
		$query=$this->db->query('select * from productos where id_producto='.$id.';');
		return $query;
	}
	function vender($data)
	{
		$query=$this->db->query('call vender('.$data['id_venta'].','.$data['cantidad_venta'].','.$data['id_producto'].','.$data['id_precio'].','.$data['precio'].',@ban);');
		$query->next_result();
		$query=$this->db->query('SELECT @ban');
		foreach ($query->result_array() as $row) 
		{
			$ban=$row['@ban'];
		}
		return $ban;
	}
}
?>