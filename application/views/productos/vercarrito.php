<div class="col-md-10">
	<div class="panel panel-info">
	  	<!-- Default panel contents -->
	  	<div class="panel-heading"><?=$movimiento?></div>
	 	 	<div class="panel-body">
	  	  		<div style="text-align:center;"class="col-md-4">
	  	  			<a href="<?=base_url()?>producto/allProductos" class="link link-cart">Regresar <span class="glyphicon glyphicon-menu-left"></span></a>
	  	  		</div>
	  	  		<div style="text-align:center;" class="col-md-4">
	  	  			<a href="<?=base_url()?>producto/<?=$funcion?>" class="link link-cart"><?=$nameLink?> <span class="glyphicon glyphicon-ok"></span></a>
	  	  		</div>
	  	  		<div style="text-align:center;" class="col-md-4">
	  	  			<a href="<?=base_url()?>producto/destruirCompras" class="link link-cart">Desacer <span class="glyphicon glyphicon-remove"></span></a>
	  	  		</div>
	 	 	</div>
	  	<!-- Table -->
	 	 	<table id="tablaCarritoCompras" class="table table-striped">
	 	   		<thead style="background-color:#19A3A3">
	 	   			<th>Categoria</th>
	 	   			<th>Nombre</th>
	 	   			<th>Precio</th>
	 	   			<th>Cantidad</th>
	 	   			<th>Subtotal</th>
	 	   			<th>Modificar</th>
	 	   		</thead>
	 	   		<tbody>
	 	   			<?php foreach($this->cart->contents() as $item){?>
	 	   			<tr>
	 	   				<form action="<?=base_url()?>producto/updateCompras" method="post">
	 	   					<input type="hidden" name='rowid' value="<?=$item['rowid']?>">
		 	   				<td><?=$item['categoria']?></td>
		 	   				<td><?=$item['name']?></td>
		 	   				<td>
		 	   					<?='$'.number_format($item['price'],2)?>
		 	   				</td>
		 	   				<td>
		 	   					<input type='text' name='qty' class="form-control" value="<?=$item['qty']?>" class="control-form">
		 	   				</td>
		 	   				<td><?=($item['qty']*$item['price'])?></td>
		 	   				<td><button class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></button></td>
	 	   				</form>
	 	   			</tr>
	 	   			<?php } ?>
	 	   			<tr>
	 	   				<td colspan="5" style="text-align:right">Total</td>
	 	   				<td><?='$'.number_format($this->cart->total(),2)?></td>
	 	   			</tr>
	 	   		</tbody>
		  	</table>
	</div>
</div>