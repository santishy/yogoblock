$(document).on('ready',function()
{
	btnCompras=$('.btnComprar');
	frmCompras=$('#frm_Compras');
	btnIC=$('#btnInsertarCarrito'); // boton de la modal insertar al carrito
	var fecha=$('#fecha_compra');
	
	//----------------------------------------------
	$(function($){
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
	});
	fecha.datepicker({showButtonPanel:true,showAnim:"drop"});
	$('#modal_compras').modal
	({
		keyboard:false,
		show:false
	});// creando la modal
	btnCompras.on('click',function(){
		var cadena='{"id":"id_producto","name":"nombre_producto"}';
		arr=JSON.parse(cadena);
		rellenarForm(arr,$(this));
		$('#modal_compras').modal('show');
	});// evento del boton comprar
	btnIC.on('click',insertarCarrito);
	//boton boton-cart para ver el carrito
	
	
});//fin del documento

function insertarCarrito()
{
	var ruta=$("#modal_compras").data('ruta');
	$.ajax({
		url:ruta,
		beforeSend:function()
		{

		},
		type:'post',
		data:$('#frm_compras').serialize(),
		dataType:'text',
		success:function(resp)
		{
			$('#modal_compras').modal('hide');
			$('.bottom-cart cart-compras badge').text(resp);
			$('.boton-carro').removeClass('glyphicon glyphicon-arrow-down').addClass('glyphicon glyphicon-arrow-up');
			$('.bottom-cart').animate({bottom:'0'});
		},
		error:function(xhr,error,estado)
	    {
	        alert(xhr+" "+error+" "+estado)
	    },
	    complete:function(xhr)
	    {
	        
	    }

	})
}
function rellenarForm(data,obj)
{

	$.each(data,function(i,v){
		$('#'+v).val(obj.parent().parent().data(i));
	})
		
		//
		
	
}