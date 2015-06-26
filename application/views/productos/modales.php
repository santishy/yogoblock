<div class="modal fade" id="modal_compras">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Comprar</h4>
      </div>
      <div class="modal-body">
        <form name="frm_compras" id="frm_compras">
          <div class="form-group">
            <label>Fecha</label>
            <input type="text" name="fecha_compra" id="fecha_compra">
          </div>
          <div class="form-group">
            <label for="cant_compra">
              <input type="hidden" name="cant_compra" class="form-control">
              <input type="hidden" name="id_producto">
              <input type="hidden" name="nombre_producto">
          </div>
          <div class="form-group">
            <label>Precio</label>
            <input name="precio_compra" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Comprar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript" src="<?=base_url()?>js/compras.js">
</script>