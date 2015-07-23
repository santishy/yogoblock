$(document).on('ready',function()
{	modalVentas=$('#modal_ventas');
	btnCompras=$('.btnComprar');
	frmCompras=$('#frm_Compras');
	btnIC=$('#btnInsertarCarrito'); // boton de la modal insertar al carrito
	var fecha=$('#fecha_compra');
	var btnInsertarVentas=$()
	btnVender=$('.btnVender');
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

	//-------------- agregar precios-------------------------------------------------------
	btnPrecios=$('.btnPrecios');
	$('#modal_precios').modal
	({
		keyboard:false,
		show:false
	});// creando la modal
	btnPrecios.on('click',function()
		{
			$('#tipo').val("");
			$('#precio').val("");
			var cadena='{"id":"id_productoV"}';
			data=JSON.parse(cadena);
			rellenarForm(data,$(this));
			$('#modal_precios').modal('show');
		});
	$('#btnInsertarPrecio').on('click',insertarPrecio);
	//---------------------- creando la modal -------------------COMPRAS------------------------
	$('#modal_compras').modal
	({
		keyboard:false,
		show:false
	});
	btnCompras.on('click',function(){
		$('#cant').val('');
		$('#precio_compra').val('');
		var cadena='{"id":"id_producto","name":"nombre_producto","categoria":"categoria"}';
		arr=JSON.parse(cadena);
		rellenarForm(arr,$(this));
		$('#modal_compras').modal('show');
	});// evento del boton comprar
	btnIC.on('click',insertarCarrito);
	
	$('.boton-carro').click(function(){//------boton boton-carro para ver el carrito y desplegar la barra inferior-----
		if($('.bottom-cart').css('bottom')!='0px')
		{
			$('.boton-carro span').removeClass('glyphicon').removeClass('glyphicon-arrow-down').addClass('glyphicon glyphicon-arrow-up');
			$('.bottom-cart').animate({bottom:'0'});	
		}
		else
		{
			$('.boton-carro span').removeClass('glyphicon glyphicon-arrow-down').addClass('glyphicon glyphicon-arrow-down');
			$('.bottom-cart').animate({bottom:'-25%'});
		}
	});
	//--------------------------------VENTAS---------------------------------------------------
	modalVentas.modal
	({
		keyboard:false,
		show:false
	});
	btnVender.on('click',function(){
		$('#frm_ventas').find(':text').each(function()
		{
			if($($(this)).attr('name')!="fecha_venta")
				$($(this)).val('');
		});
		var cadena='{"id":"id_productoVT","name":"nombre_productoV","categoria":"categoriaV"}';
		$("#precio_venta").empty();
		arr=JSON.parse(cadena);
		rellenarForm(arr,$(this));
		//alert(document.frm_ventas.id_productoV.value)
		getPreciosV();
		modalVentas.modal('show');
	});
	btnInsertarVentas.on('click',function()
	{
		if(typeof $('#id_precio').val() == 'undefined' || $('#id_precio').val() === null || $('#id_precio').val() === '')
			alert('Agregue un precio a este producto, para continuar');
		else
			insertarCarritoV();
	});
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
			$('#numProductos').text(resp);
			$('.boton-carro span').removeClass('glyphicon glyphicon-arrow-down').addClass('glyphicon glyphicon-arrow-up');
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
}
function getPreciosV()
{
	var ruta=$('#modal_ventas').data('rutap');
	$.ajax
	({
		url:ruta,
		data:{id_producto:document.frm_ventas.id_productoV.value},
		type:'post',
		dataType:'json',
		success:function(resp)
		{
			for(var i=0;i<resp.length;i++)
				$('#precio_venta').append("<option value="+resp[i].id_precio+">"+resp[i].tipo+": $"+resp[i].precio+"</option>");
		},
		error:function(xhr,error,estado)
	    {
	        alert(xhr+" "+error+" "+estado)
	    },
	    complete:function(xhr)
	    {
	        
	    }
	});
}
function insertarPrecio()
{
	var ruta=$('#modal_precios').data('ruta');
	$.ajax({
		url:ruta,
		data:$('#frm_precios').serialize(),
		type:'post',
		dataType:'text',
		beforeSend:function()
		{

		},
		success:function(resp)
		{
			if (resp==0)
				alert('No se inserto');
			else
			{
				$("#modal_precios").modal('hide');
			}
		},
		error:function(xhr,error,estado)
		{
			alert(xhr+" "+error+" "+estado)
		},
		complete:function(xhr)
		{
			
		}
	});
}
function insertarCarritoV()
{
	var ruta=$("#modal_compras").data('rutav');
	$.ajax({
		url:ruta,
		beforeSend:function()
		{

		},
		type:'post',
		data:$('#frm_ventas').serialize(),
		dataType:'text',
		success:function(resp)
		{
			$('#modal_ventas').modal('hide');
			$('#numProductos').text(resp);
			$('.boton-carro span').removeClass('glyphicon glyphicon-arrow-down').addClass('glyphicon glyphicon-arrow-up');
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