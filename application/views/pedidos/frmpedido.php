<div class="col-md-4">
	<div class="panel panel-success">
	  	<div class="panel-heading">
	    	<h3 class="panel-title">Pedido</h3>
	  	</div>
	  	<div class="panel-body">
	   		<form id="frmPedido" action="<?=base_url()?>pedido/registrarPedido" data-ruta="<?=base_url()?>pedido/addPedido" data-ban="<?=$ban?>">
	   			<div class="form-group">
	   				<label>Flete</label>
	   				<select name="flete" class="form-control">
	   					<option value="SI">Si</option>
	   					<option value="No">No</option>
	   				</select>
	   			</div>
	   			<div class="form-group">
	   				<label>Fecha de Entrega</label>
	   				<input class="form-control" name="fecha_entrega" type="date">
	   			</div>
	   			<div class="form-group">
	   				<label>Status</label>
	   				<select class="form-control">
	   					<option value="SI">Pendiente</option>
	   					<option value="No">Urgente</option>
	   				</select>
	   			</div>
	   			<div class="form-group">
	   				<button type="button" id="btnAddPedido" class="btn btn-info">Guardar</button>
	   			</div>
	   		</form>
	  	</div>
	</div>
</div>
<div class="col-md-4">
	<div class="panel panel-success">
	  	<div class="panel-heading">
	    	<h3 class="panel-title">Destino</h3>
	  	</div>
	  	<div class="panel-body">
	   		<form id="frmDestino" action="<?=base_url()?>pedido/agregarDestino" data-ruta="<?=base_url()?>pedido/addDestino" data-ban="<?=$ban?>">
	   			<div class="form-group">
	   				<label>Estado</label>
	   				<input type="text" name="estado" id="estado" class="form-control">
	   			</div>
	   			<div class="form-group">
	   				<label>Ciudad</label>
	   				<input class="form-control" name="ciudad" id="ciudad" type="text">
	   			</div>
	   			<div class="form-group">
	   				<label>telefono</label>
	   				<input class="form-control" name="telefono" id="telefono" type="text">
	   			</div>
	   			<div class="form-group">
	   				<label>Lugar</label>
	   				<input class="form-control" name="lugar" id="lugar" type="text">
	   			</div>
	   			<div class="form-group">
	   				<button class="btn btnAddDestino btn-info" type="button">Guardar</button>
	   			</div>
	   		</form>
	  	</div>
	</div>
</div>

<div class="col-md-4">
	<div class="panel panel-info">
	  	<div class="panel-heading">
	    	<h3 class="panel-title">Mas Destinos</h3>
	  	</div>
	  	<div class="panel-body">
	  		<?php foreach($query->result() as $row){?>
			<div class="col-md-12 divDestino">
				<h4  class="destino" data-id="<?=$row->id_destino?>" data-ruta="<?=base_url()?>pedido/getDestino">Escoger destino</h4>
				<ul>
					<li><?=$row->ciudad?></li>
					<li><?=$row->lugar?></li>
					<li><?=$row->telefono?></li>
				</ul>
			</div>
			<?php }?>
	  	</div>
	</div>
</div>
<script src="<?=base_url()?>js/pedido.js"></script>
<!-- Small modal -->
<div id="modalConfir" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-ruta="<?=base_url()?>producto/sessionCart">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">¿Qué desea hacer?</h4>
      </div>
      <div class="modal-body">
        	<a href="#" id="otroDestino" style="display:block" class="link-confir"><span class="glyphicon glyphicon-plus-sign"></span> Agregar otro destino</a>
        	<a href="<?=base_url()?>credito/obtenerCredito" id="sig" style="display:block" class="link-confir"><span class="glyphicon glyphicon-ok-sign"></span> Listo</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>