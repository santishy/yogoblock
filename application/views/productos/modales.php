<div id="modal_compras" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-ruta="<?=base_url()?>producto/insertarCarrito">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Compras</h4>
      </div>
      <div class="modal-body">
        <form name="frm_compras" id="frm_compras">
          <div class="form-group">
            <label>Fecha</label>
            <input type="text" class="form-control" name="fecha_compra" id="fecha_compra" value="<?=$fecha_compra?>">
          </div>
          <div class="form-group">
            <label for="cant_compra">Cantidad</label>
              <input type="text" name="cant_compra" class="form-control">
              <input type="hidden" name="id_producto" id="id_producto">
              <input type="hidden" name="nombre_producto" id="nombre_producto">
          </div>
          <div class="form-group">
            <label>Precio de compra</label>
            <input name="precio_compra" id="precio_compra" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnInsertarCarrito" class="btn btn-primary">Comprar</button>
      </div>
      
    </div>
  </div>
</div>
<script type="text/javascript" src="<?=base_url()?>js/compras.js">
</script>