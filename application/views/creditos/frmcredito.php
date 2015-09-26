<div class="col-md-4">
	<div class="panel panel-primary">
	  	<div class="panel-body">
	    	Credito
	    	<hr>
	    	<form id="frmCredito" action="<?=base_url()?>credito/addCredito" method="post">
	    		<div class="form-group">
	    			<label>Interes</label>
	    			<input name="interes" class="form-control" >
	    		</div>
	    		<div class="form-group">
	    			<label>Fecha limite</label>
	    			<input name="fecha_limite" type="date" class="form-control">
	    			<input type="hidden" name="id_venta" value="<?=$id_venta?>">
	    		</div>
	    		<div class="form-group">
	    			<label>Monto</label>
	    			<input name="monto" type="text" class="form-control" value="">
	    			<input type="hidden" name="fecha_pago" value="<?=$fecha_hoy?>">
	    			<input type="hidden"  name="total_credito" value="<?=$total_venta?>">
	    			<input type="hidden"  name="saldo" value="<?=$total_venta?>">
	    			<input type="hidden" name="id_cliente" value="<?=$this->session->userdata('id_cliente')?>">
	    		</div>
	    		<div class="form-group">
	    			<button class="btn btn-info">Listo <span class="glyphicon glyphicon-ok"></span></button>
	    		</div>
	    	</form>
	    	<?=validation_errors()?>
	  	</div>
	</div>
</div>