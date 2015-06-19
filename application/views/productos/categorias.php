<div class="col-md-4">
	<div class="panel panel-default">
	  	<div class="panel-body">
		<p>Agregar Categorias</p>    
		<hr>
		<form action="<?=base_url()?>categoria/agregarCategoria" method="post" rule="form">
			<div class="form-group">
				<label>Categoria</label>
				<input class="form-control" name="categoria" plaheholder="Introduce el nombre">
			</div>
			<div class="form-group">
				<button class="btn btn-info">Guardar</button>
			</div>
		</form>
	 	</div>
	</div>
	<?=validation_errors()?>
</div>
