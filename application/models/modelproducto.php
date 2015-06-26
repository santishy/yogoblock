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
}
?>