<div class="col-md-2">
	<div class="panel panel-default">
		<div class="panel-body">
		    CREDITO
		    <hr>
		    <FORM id="frm_credito" name='frm_credito'>
		    	<div class="radio">
				  	<label>
				    	<input type="radio" name="credito" id="optionsRadios1" value="SI">
				    	SI
				  	</label>
				</div>
				<div class="radio">
				  	<label>
				    	<input type="radio" name="credito" id="optionsRadios2" value="NO">
				    	NO
				  	</label>
				</div>
				<div class="form-group">
					<button id="btnVenta" type="button" class="btn btn-info " data-ruta="<?=base_url()?>producto/terminarVenta">Listo <span class="glyphicon glyphicon-ok"></span></button>
				</div>
		    </FORM>	
	  	</div>
	</div><!--panel-->
	<div id="panelExistencias"class="panel panel-default" style="display:none">
		<div class="panel-body">
		    Venta mayor a existencia, productos:
		    <hr>
		    <ul id="lista-productos-exists">
		    </ul>
	  	</div>
	</div><!--panel-->
</div>
<div class="col-md-10">
	<div class="panel panel-info">
	  	<div class="panel-heading">
	    	<h3 class="panel-title">CLIENTE</h3>
	  	</div>
	  	<div class="panel-body">
	 		<form class="form-horizontal" name="frm_envio" id="frm_envio" method="post" action="<?=base_url()?>envios/registroEnvio" disabled>
						<div class="form-group">
							<label class="col-md-2 control-label">Nombre</label>
							<div class="col-md-4">
								<input type="text" name="nombre" class="form-control" value="<?=set_value('nombre')?>">
							</div>	
							<label class="col-md-2 control-label">Paterno</label>
							<div class="col-md-4">
								<input type="text" name="apellido_paterno" class="form-control" value="<?=set_value('apellido_paterno')?>">
							</div>	
						</div>
						<div class="form-group">
							
							<label class="col-md-2 control-label">Materno</label>
							<div class="col-md-4">
								<input type="text" name="apellido_materno" class="form-control" value="<?=set_value('apellido_materno')?>">
							</div>	
							<label class="col-md-2 control-label">Telefono</label>
							<div class="col-md-4">
								<input type="text" name="telefono" class="form-control" value="<?=set_value('telefono')?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Calle</label>
							<div class="col-md-4">
								<input name="calle" class="form-control" value="<?=set_value('calle')?>">
							</div>

							<label class="col-md-2 control-label">Colonia</label>
							<div class="col-md-4">
								<input name="colonia" class="form-control" value="<?=set_value('calle')?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Int.</label>
							<div class="col-md-4">
								<input type="text" name="n_interior" class="form-control" value="<?=set_value('n_interior')?>">
							</div>	
							<label class="col-md-2 control-label">Ext.</label>
							<div class="col-md-4">
								<input type="text" name="n_exterior" class="form-control" value="<?=set_value('n_exterior')?>">
							</div>	
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Ciudad</label>
							<div class="col-md-4">
								<input type="text" name="ciudad" class="form-control" value="<?=set_value('ciudad')?>">
							</div>	
							<label class="col-md-2 control-label">Estado</label>
							<div class="col-md-4">
								<input type="text" name="estado" class="form-control" value="<?=set_value('estado')?>">
							</div>	
						</div>
						<div class="form-group">
			
							<label class="col-md-2 control-label"></label>
							<div class="col-md-3">
								<button class="btn btn-info">Listo <span class="glyphicon glyphicon-ok"></span></button>
							</div>	
						</div>
						<div class="form-group">
							<?=validation_errors()?>
						</div>
					</form>
	  	</div>
	</div>
</div>
<script src="<?=base_url()?>js/ventas.js">
</script>