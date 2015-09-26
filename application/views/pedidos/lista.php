<div class="col-md-12">
	<div class="panel panel-warning">
  		<div class="panel-heading"><h3>Pedidos</h3></div>
 	<div class="panel-body">
 		<div class="container-body">
 			<div class="col-md-4">
	 			<ul class="nav nav-pills nav-stacked">
	  				<li role="presentation">
	  					<a class="btn btn-default" href="<?=base_url()?>pedido/buscarEstado/pendiente">PENDIENTE</a>
	  				</li>
	  				<li role="presentation">
						<a class="btn btn-default" href="<?=base_url()?>pedido/buscarEstado/entregado">ENTREGADO</a>
	  				</li>
	  				<li role="presentation">
						<a class="btn btn-default" href="<?=base_url()?>pedido/buscarEstado/cancelado">CANCELADO</a>			
	  				</li>
				</ul>
			</div>
			<div class="col-md-4">
				<h2><?=strtoupper($estado)?></h2>
				<hr>
				<form action="<?=base_url()?>pedido/buscar" method="post">
					<div class="input-group">
					  <span class="input-group-addon " id="basic-addon1 "><span class="glyphicon glyphicon-search"></span></span>
					  <input type="text" name="clave"class="form-control" placeholder="Buscar" aria-describedby="basic-addon1">
					</div>
				</form>
			</div>
 		</div>
 	</div>
	<table class="tabla table">
		<thead>
			<th>Nota</th>
			<th>Pedido</th>
			<th>Destino/s</th>
			<th>Cliente</th>
			<th>Credito</th>
			<th>Imprimir</th>
			<th>Opciones</th>
		</thead>
		<tbody>
			<?php foreach ($query->result() as $row)
			{?>
				<tr>
					<td class="t-venta" data-id="<?=$row->id_venta?>">
						<p><?=$row->id_venta?></p>
					</td>
					<td>
						<p>
							<b>Fecha entrega:</b><?=$row->fecha_entrega?>
						</p>
						<p>
							<b>Flete:</b> <?=$row->flete?>
						</p>
						<p><b>Total:</b> $<?=number_format($row->total_venta,2,".",",")?></p>
					</td>
					<td>
						<p class="t-destino" data-ruta="<?=base_url()?>pedido/getDestinos" data-id="<?=$row->id_pedido?>">Ver Destino/s...</p>
					</td>
					<td>
						<p>
							<?=$row->nombre.' '?><?=$row->apellido_paterno?>
						</p>
						<p class="t-cliente" data-id="<?=$row->id_cliente?>">
							Ver...
						</p>
					</td>
					<td>
						<?php if($row->credito=="SI"){?>
							<p><b>Interes:</b> <?=$row->interes?>%</p>
							<p><b>Saldo:</b> $<?=number_format($row->saldo,2,".",",")?> </p>
							<p><b>Total Credito:</b> $<?=number_format($row->total_credito,2,".",",")?></p>
							<p class="t-pagos" data-id="<?=$row->id_credito?>"><a href="<?=base_url()?>credito/verPagos/<?=$row->id_credito?>">Ver pagos...</a></p>
						<?php }else{ ?>
							No
						<?php }?>
					</td>
					<td style="text-align:center">
						<a style="color:white;"class="btn btn-info btn-xs" href="<?=base_url()?>credito/postNota/<?=$row->id_venta?>" target="_blank"><span class="glyphicon glyphicon-print"></span></a>
					</td>	
					<td>
						<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    Cambiar E.
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						    <li><a href="<?=base_url()?>pedido/cambiarEstado/pendiente/<?=$row->id_pedido?>">PENDIENTE</a></li>
						    <li><a href="<?=base_url()?>pedido/cambiarEstado/entregado/<?=$row->id_pedido?>">ENTREGADO</a></li>
						    <li><a href="<?=base_url()?>pedido/cambiarEstado/cancelado/<?=$row->id_pedido?>">CANCELADO</a></li>
						  </ul>
						</div>
					</td>
				</tr>
			<?php 
			}
			?>
		</tbody>
	</table>
</div><!--panel-->
	<div class="well">
		<center><?=$paginacion?></center>
	</div>
</div>
<div class="modal fade" id="ventana">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> </h4>
      </div>
      <div class="modal-body" id="body-ventana">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?=base_url()?>js/listvent.js"></script>