<div class="col-md-12">
	<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading">Clientes</div>
		<div class="panel-body">
		    <p>
		    	<center><?=$paginacion?></center>
		    </p>
		</div>
	  	<table class="table">
	  		<thead>
	  			<th>Nombre</th>
	  			<th>Calle</th>
	  			<th>Telefono</th>
	  			<th>Ciudad</th>
	  			<th>Estado</th>
	  			<th>Opciones</th>
	  		</thead>
	  		<tbody>
	  			<?php foreach($query->result() as $row){?>
	  			<tr>
	  				<td><?=$row->nombre.' '.$row->apellido_paterno.' '.$row->apellido_materno?></td>
	  				<td><?=$row->calle?></td>
	  				<td><?=$row->telefono?></td>
	  				<td><?=$row->ciudad?></td>
	  				<td><?=$row->estado?></td>
	  				<td>
	  					<form action="<?=base_url()?>producto/crearVarCliente" method="post" style="display:inline-block">
	  						<input type="hidden" name="id_cliente" value="<?=$row->id_cliente?>">
	  						<button class="btn btn-xs btn-info"><span class="glyphicon glyphicon-shopping-cart"></span></button>
	  					</form>
	  					<form action="<?=base_url()?>cliente/vistaModificar" method="post" style="display:inline-block">
	  						<input type="hidden" name="id_cliente" value="<?=$row->id_cliente?>">
	  						<button class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></button>
	  					</form>
	  				</td>
	  			</tr>
	  			<?php }?>
	  		</tbody>
		</table>
	</div>
	<div class="well">
		<center><?=$paginacion?></center>
	</div>
</div>