<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelCliente extends CI_Model 
{
	function __construct ()
	{
		parent::__construct();
	}
	function insertarCliente($data)
	{
		$query=$this->db->insert('cliente',$data);
		return $query;
	}
	function comprobarCliente($data)
	{
		$this->db->where('nombre',$data['nombre']);
		$this->db->where('apellido_paterno',$data['apellido_paterno']);
		$this->db->where('apellido_materno',$data['apellido_materno']);
		$this->db->where('calle',$data['calle']);
		$this->db->where('num_ext',$data['num_ext']);
		$this->db->where('estado',$data['estado']);
		$query=$this->db->get('clientes');
		return $query;
	}
}
?>