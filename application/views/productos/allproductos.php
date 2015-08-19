<div class="col-md-4">
	<div class="panel panel-default">
	  	<div class="panel-body">
		<p>Agregar Producto</p>    
		<hr>
		<form action="<?=base_url()?>producto/agregarProducto" method="post" rule="form">
			<div class="form-group">
				<label>Categoria</label>
				<select name="id_categoria" class="form-control">
					<?php foreach($query->result() as $row)
					{ ?>
						<option value="<?=$row->id_categoria?>"><?=$row->categoria?></option>
					<?php }?>
				</select>
			</div>
			<div class="form-group">
				<span id="helpBlock" class="help-block">Agregar otra categoria sino existe <a href="<?=base_url()?>categoria/agregarCategoria" class="btn btn-primary btn-xs active" role="button"><span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true"></span></a></span>
			</div>
			<div class="form-group">
				<label>Nombre</label>
				<input class="form-control" name="nombre_producto" plaheholder="Introduce el nombre">
			</div>
			<div class="form-group">
				<label>Medida</label>
				<input class="form-control" name="medida" plaheholder="Introduce la medida">
			</div>
			<div class="form-group">
				<label>Precio de compra</label>
				<input class="form-control" name="precio_compra" plaheholder="Introduce el nombre">
			</div>
			<div class="form-group">
				<label>Descripcion</label>
				<textarea name="descripcion"class="form-control"></textarea>
			</div>
			<div class="form-group">
				<button class="btn btn-info">Guardar</button>
			</div>
		</form>
	 	</div>
	</div>
	<?=validation_errors()?>
</div>
<div class="col-md-8">
	<div class="panel panel-success">
	  <!-- Default panel contents -->
	  <div class="panel-heading">Productos</div>
	  <!-- Table -->
	  <table class="table table-condesed">
	  	<thead>
	  		<TH>NOMBRE</TH>
	  		<TH>PRECIO C.</TH>
	  		<TH>CATEGORIA</TH>
	  		<th>MEDIDA</th>
	  		<TH>DESCRIPCION</TH>
	  		<TH>EXISTENCIA</TH>
	  		<th>OPCIONES</th>
	  	</thead>
	  	<tbody>
	  		<?php foreach($productos->result() as $row) {?>
	  		<tr>
	  			<td><?=$row->nombre_producto?></td>
	  			<td><?=$row->precio_compra?></td>
	  			<td><?=$row->categoria?></td>
	  			<td><?=$row->medida?></td>
	  			<td><?=$row->descripcion?></td>
	  			<td><?=$row->existencia?></td>
	  			<td data-name="<?=$row->nombre_producto?>" data-id="<?=$row->id_producto?>" data-categoria="<?=$row->categoria?>">
	  				<div style='display:inline-block'>
	  					<button type="button" class="btn btn-info btnComprar btn-xs"><span class="glyphicon glyphicon-shopping-cart"></span></button>
	  				</div>
	  				<div style='display:inline-block'>
	  					<button type="button" class="btn btn-info btnPrecios  btn-xs"><span class='glyphicon glyphicon-usd'></span></button>
	  				</div>
	  				<div style='display:inline-block'>
	  					<button type="button" class="btn btn-default  btnVender btn-xs"><span class="glyphicon glyphicon-shopping-cart"></span></button>
	  				</div>
	  			</td>
	  		</tr>
	  		<?php }?>
	  	</tbody>
	  </table>
	</div>
	<div class="well"><?=$paginacion?></div>
</div>
<div class="bottom-cart">
	<div id="boton-carro" class="boton-carro">
		<span class="glyphicon glyphicon-arrow-down"></span>
	</div>
	<div  class="ver-carrito col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
		<p  class="p-linea"> <span id="item1-carrito">Terminar </span>
			<a id="link-movimiento"href="#" class="btn btn-primary btn-xs">
				<span class="glyphicon glyphicon-ok"></span>
			</a>
		</p>
		<p class="p-linea">Productos 
			<span id="numProductos" class="badge"><?=$items?></span>
		</p>
		<p>
			<a id="ver-carrito" href="#" class="link" data-base="<?=base_url()?>" data-ruta="<?=base_url()?>producto/activarLink">Ver Carrito
				<span class="glyphicon glyphicon-list-alt"></span>
			</a>
		</p>
	</div>
</div>