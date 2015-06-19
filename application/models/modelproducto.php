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
}
?>