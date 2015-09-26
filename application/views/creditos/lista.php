<div class="col-md-6">
	<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">Pagos</div>
		<div class="panel-body">
		  <p><?php $row=$query->row_array();?><?=$row['nombre'].' '.$row['apellido_paterno'].' '.$row['apellido_materno']?></p>
		</div>
		<!-- Table -->
		<table class="table table-bordered">
			<thead>
				<th>
					Fecha del pago
				</th>
				<th>
					Monto
				</th>
				<th>
					Debe
				</th>
			</thead>
			<tbody>
				<?php $monto=0; foreach ($query->result() as $row)
				 {?>
					<tr>
						<td>
							<?=$row->fecha_pago?>
						</td>
						<td>
							<?=$row->monto?>
							<?php $monto+=$row->monto?>
						</td>
						<td>
							<?=$row->total_credito-$row->monto?>
						</td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-body">
			<?php $row=$query->row_array();?>
			<p class="panel-pagos">Total Credito: <strong>$<?=number_format($row['total_credito'],2,".",",")?></strong></p>
			<p class="panel-pagos">Saldo: <strong>$<?=number_format($row['saldo'],2,".",",")?></strong></p>
			<p class="panel-pagos">Saldo: <strong><?=$row['interes']?>%</strong></p>
			<a style="font-size:1.2em;" href="<?=base_url()?>pedido/listaPedido">Ver pedidos</a>
		</div>
	</div>
</div>