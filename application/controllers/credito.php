<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credito extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('ModelCliente');
		$this->form_validation->set_message('required', '%s es un campo requerido');
		$this->form_validation->set_message('valid_email', '%s No es un email valido');
		$this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
	}
	function obtenerCredito()
	{
		$query=$this->ModelCliente->credito($this->session->userdata('id_venta'));
		if($query->num_rows()>0)
		{
			$row=$query->row_array();
			if($row['credito']=='SI')
			{
				$this->vistaCredito($row);
			}
			else
			{
				
				//$this->eliminarVarSession();
				redirect(base_url().'pedido/listaPedido','refresh');

			}
		}

	}
	function vistaCredito($data)
	{
		date_default_timezone_set('America/Monterrey');
		$data['fecha_hoy']=date('Y-m-d H:i:s');
		$data['id_venta']=$this->session->userdata('id_venta');
		$this->load->view('general/header',$data);
		$this->load->view('general/scripts');
		$this->load->view('creditos/frmcredito');
		$this->load->view('general/footer');
	}
	function addCredito()
	{
		$this->form_validation->set_rules('saldo','Saldo','required|callback_comprobarCredito');
		$this->form_validation->set_rules('total_credito','Total de credito','required');
		$this->form_validation->set_rules('interes','Interes','required');
		$this->form_validation->set_rules('fecha_limite','Fecha limite','required');
		$this->form_validation->set_rules('id_venta','Id venta','required');
		$this->form_validation->set_rules('fecha_pago','Fecha pago','required');
		$this->form_validation->set_rules('monto','Monto','required');
		if($this->form_validation->run()==false)
		{
			$this->obtenerCredito();
		}
		else
		{
			$monto=$this->input->post('monto');
			$interes=$this->input->post('interes');
			$credito['total_credito']=$this->input->post('total_credito')+($this->input->post('total_credito')*($interes/100));
			$credito['saldo']=$credito['total_credito']-$monto;
			//$credito['total_credito']=$this->input->post('total_credito');
			$credito['interes']=(float)$interes;
			$credito['fecha_limite']=$this->input->post('fecha_limite');
			$credito['id_venta']=(int)$this->input->post('id_venta');
			$credito['id_cliente']=$this->session->userdata('id_cliente');
			$pago['fecha_pago']=$this->input->post('fecha_pago');
			$pago['monto']=$monto;
			$query=$this->ModelCliente->addCredito($credito);
			if($query)
			{
				$query=$this->ModelCliente->maxIdCredito();
				$id=0;
				foreach ($query->result() as $row) 
				{
					$pago['id_credito']=$row->id_credito;
				}
				$query=$this->ModelCliente->addPago($pago);
			}
			else
			{
				$this->obtenerCredito();
				echo 'consulte su proveedor';
			}
		}
		echo '<script>window.open("'.base_url().'credito/crearNota","_blank");</script>';
		redirect(base_url().'pedido/listaPedido','refresh');
		//$this->eliminarVarSession();
	}
	function eliminarVarSession()
	{
		$this->session->unset_userdata('id_venta');
		$this->session->unset_userdata('id_cliente');
		$this->session->unset_userdata('id_pedido');
		if($this->session->userdata('id_destino'))
			$this->session->unset_userdata('id_destino');
	}
	function comprobarCredito()
	{
		$id_venta=$this->input->post('id_venta');
		$query=$this->ModelCliente->comprobarCredito($id_venta);
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('comprobarCredito','Ocurrio un error, desaga los cambios y realize de nuevo el proceso');
			return false;
		}
		else
			return true;
	}
	function postNota()
	{
		$id=$this->uri->segment(3);
		$this->session->set_userdata('id_venta',$id);
		$this->crearNota();
	}
	function crearNota()
	{
		$query=$this->ModelCliente->getNota($this->session->userdata('id_venta'));
		$row=$query->row_array();
		require('fpdf/fpdf.php');
		$pdf=new FPDF('P','mm',array(80,200));
		$pdf->AddPage();
		$pdf->Image('img/logo.PNG',20,5,40,10);
		$pdf->SetMargins(5,10,5);
		$pdf->SetFont('Arial','B',9);
		$pdf->Ln(10);
		$pdf->Cell(0,5,'YOGO BLOCK S.A DE C.V.',0,1,'C');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(0,5,'***CONSTRUCTORA***',0,1,'C');
		$pdf->Cell(0,1,'JALISCO # 121 COLONIA LLANOS DE SAHUAYO',0,1,'C');
		$pdf->Cell(0,5,'TEL 01 353 128 1362',0,1,'C');
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(0,1,'SAHUAYO MICHOACAN',0,1,'C');
		$pdf->Ln(5);
		$pdf->Cell(0,5,$row['fecha_venta'],'TB',1,'C');
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln(5);
		$pdf->Cell(23,5,'Venta a Credito:',0,0,'L');
		$pdf->SetFont('Arial','U',8);
		if($row['credito']=='SI')
			$pdf->Cell(10,5,utf8_encode('SI'),0,0,'L');
		else
			$pdf->Cell(10,5,utf8_encode('NO'),0,0,'L');
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(10,5,'Nota:',1,0,'L',1);
		$pdf->SetFont('Arial','',10);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(25,5,$row['id_venta'],1,1,'L',0);
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln(3);
		$pdf->Cell(10,5,'CLIENTE:',0,1,'L');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(0,1,utf8_encode($row['nombre']).' '.utf8_encode($row['apellido_paterno']).' '.utf8_encode($row['apellido_materno']),0,1);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(0,5,'Mercancia:','B',1,'C');
		$pdf->Ln();
		$pdf->SetFont('Arial','',8);
		$query=$this->ModelCliente->getVenta($this->session->userdata('id_venta'));
		$pdf->SetFont('Arial','B',9);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(27,5,'Nombre','TRL',0,'C',1);
		$pdf->Cell(30,5,'Medida','TR',0,'C',1);
		$pdf->Cell(13,5,'Cant.','TR',1,'C',1);
		$pdf->SetFont('Arial','',8);
		$pdf->SetTextColor(0,0,0);
		foreach ($query->result() as $fila) 
		{
			$pdf->Cell(27,5,$fila->nombre_producto,1,0,'L');	
			$pdf->Cell(30,5,$fila->medida,1,0,'L');	
			$pdf->Cell(13,5,$fila->cantidad_venta,1,0,'L');	
			$pdf->Ln();
		}
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(40,5,'Interes','BRL',0,'R');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(30,5,'$'.number_format($row['interes'],2,".",","),'BR',1,'L');
		$pdf->SetFont('Arial','B',8);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(40,5,'TOTAL','BRL',0,'R',1);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(30,5,'$'.number_format($row['total_venta'],2,".",","),'BR',1,'L',1);
		$pdf->Ln();
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(15,5,'Pago:',0,0,'L');
		//$pdf->Cell(23,6,utf8_encode($color),0,0,'L');
		if($row['credito']=='SI')
			$pdf->Cell(50,5,'$'.number_format($row['total_venta'],2,".",","),0,0,'L');
		else
			$pdf->Cell(50,5,'$'.number_format($row['monto'],2,".",","),0,0,'L');
		//$pdf->MultiCell(0,3,utf8_encode($falla),0,'L');
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(5);
		$pdf->MultiCell(60,3,"YOGO BLOCK LE OFRECE LOS MEJORES PRECIOS, EN SU GRAN VARIEDAD DE PRODUCTOS (BLOQUES, ARENA, GONDOLA)",'BT','L');
		$pdf->SetFont('Arial','UB',7);
		$pdf->Cell(0,5,'http://www.yogoblock.com/yogo/',0,1,'C');
		$this->eliminarVarSession();
		$pdf->output();
		return $pdf;
	}
	function verPagos()
	{
		$id_credito=$this->uri->segment(3);
		$data['query']=$this->ModelCliente->getPagos($id_credito);
		$this->load->view('general/header',$data);
		$this->load->view('general/scripts');
		$this->load->view('creditos/lista');
		$this->load->view('general/footer');
	}
}