<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelCliente extends CI_Model 
{
	function __construct ()
	{
		parent::__construct();
	}
	function insertarCliente($data)
	{
		$query=$this->db->insert('clientes',$data);
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
	function addPedido($data)
	{
		$query=$this->db->insert('pedidos',$data);
		return $this->db->affected_rows();
	}
	function getMaxId()
	{
		$query=$this->db->query('select max(id_pedido) as id_pedido from pedidos');
		return $query;
	}
	function numClientes()
	{
		$query=$this->db->query('select count(id_cliente) as nume from clientes');
		$nume=0;
		foreach ($query->result() as $row)
		{
			$nume=$row->nume;
		}
		return $nume;
	}
	function getClientes($uri,$tope)
	{
		$query=$this->db->query('select *from clientes limit '.$uri.','.$tope.';');
		return $query;
	}
	//----sobre destino-------------------------------------------------------------------
	function comprobarDestino($data)
	{
		$this->db->where('id_cliente',$data['id_cliente']);
		$this->db->where('estado',$data['estado']);
		$this->db->where('ciudad',$data['ciudad']);
		$this->db->where('lugar',$data['lugar']);
		$this->db->where('telefono',$data['telefono']);
		$query=$this->db->get('destinos');
		return $query;
	}
	function addDestino($data)
	{
		$this->db->trans_start();
		$this->db->insert('destinos',$data);
		$query=$this->maxIdDestino();
		if($query->num_rows()>0)
			$row=$query->row_array();
		$this->addDet_dest_ped($row['id_destino'],$this->session->userdata('id_pedido'));
		$this->db->trans_complete();
	}
	function getDestinos2($id)
	{
		$query=$this->db->query('select *from pedidos p join det_dest_ped d on p.id_pedido=d.id_pedido
			 join destinos dt on d.id_destino=dt.id_destino where d.id_pedido='.$id.'; ');
		return $query;
	}
	function addDet_dest_ped($id_destino,$id_pedido)
	{
		
		$query=$this->db->query('insert into det_dest_ped (id_destino,id_pedido) values ('.$id_destino.','.$id_pedido.');');
		return $query;
	}
	function maxIdDestino()
	{
		$query=$this->db->query('select max(id_destino) as id_destino from destinos');
		return $query;
	}
	function getDestinos($id)
	{
		$this->db->where('id_cliente',$id);
		$query=$this->db->get('destinos');
		return $query;
	}
	function comprobarDet_dest_ped($destino,$pedido)
	{
		$this->db->where('id_destino',$destino);
		$this->db->where('id_pedido',$pedido);
		$query=$this->db->get('det_dest_ped');
		return $query;
	}
	function getDestino($id)
	{
		$this->db->where('id_destino',$id);
		$query=$this->db->get('destinos');
		return $query;
	}
	//---------------------------Crédito---------------------------------------------------------//
	function credito($id)
	{
		$this->db->where('id_venta',$id);
		$query=$this->db->get('ventas');
		return $query;
	}
	function getPagos($id)
	{
		$query=$this->db->query('select *from clientes join creditos on clientes.id_cliente=creditos.id_cliente
			join pagos on creditos.id_credito=pagos.id_credito where creditos.id_credito='.$id.';');
		return $query;
	}
	function addCredito($data)
	{
		$query=$this->db->insert('creditos',$data);
		return $query;
	}
	function addPago($data)
	{
		$query=$this->db->insert('pagos',$data);
		return $query;
	}
	function comprobarCredito($id)
	{
		$this->db->where('id_credito',$id);
		$query=$this->db->get('creditos');
		return $query;
	}
	function getNota($id)
	{
		$query=$this->db->query('call getNota('.$id.');');
		$query->next_result();
		return $query;
	}
	function maxIdCredito()
	{
		$query=$this->db->query('select max(id_credito) as id_credito from creditos');
		return $query;
	}
	function getVenta($id)
	{
		$query=$this->db->query('select *from productos p left join det_precios_ventas dpv on p.id_producto=dpv.id_producto left join precios ps on ps.id_precio=
    	dpv.id_precio left join det_ven_prodp dv on dpv.id=dv.id left join ventas v on v.id_venta=dv.id_venta where v.id_venta='.$id.';');
    	return $query;
	}
	function getVentas($uri,$tope,$estado)
	{
		$query=$this->db->query('call getVentas('.$uri.','.$tope.',"'.$estado.'");');
		$query->next_result();
		return $query;
	}
	function numVentas($estado)
	{
		$query=$this->db->query('call numVentas("'.$estado.'");');
		$query->next_result();
		$nume=0;
		foreach ($query->result_array() as $row) 
		{
			$nume=$row['nume'];
		}
		return $nume;
	}
	function buscarNota($clave)
	{
		$query=$this->db->query('call buscarNota('.$clave.')');
		$query->next_result();
		return $query;
	}
	function buscarNotaNombre($clave)
	{
		$query=$this->db->query('call buscarNotaNombre("'.$clave.'");');
		$query->next_result();
		return $query;
	}
	function cambiarEstado($id,$data)
	{
		$this->db->where('id_pedido',$id);
		$this->db->update('pedidos',$data);
	}
}
?>