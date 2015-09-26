$(document).on('ready',function()
{
	$("#ventana").modal
	({
		keyboard:true,
		backdrop:false,
		show:false
	});
	var btnDestino=$(".t-destino");
	btnDestino.on('click',function(){
		getDestinos($(this));
		
	});
});

function getDestinos(e)
{
	var ruta= e.data('ruta');
	var id=e.data('id');
	var body=$("#body-ventana");
	$.ajax({
		url:ruta,
		beforeSend:function(){

		},
		data:{id_pedido:id},
		type:'post',
		dataType:'json',
		success:function(resp)
		{
			if(!jQuery.isEmptyObject(resp))
			{
				body.find('p,hr').remove();
				$('#ventana').find('h4').text('');
				$('#ventana h4').append('Destinos');
				for(var i=0;i<resp.length;i++)
				{
					body.append('<p><label>Estado</label>: '+resp[i].estado+'</p>');
					body.append('<p><label>Ciudad</label>: '+resp[i].ciudad+'</p>');
					body.append('<p><label>Lugar</label>: '+resp[i].lugar+'</p>');
					body.append('<p><label>Telefono</label>: '+resp[i].telefono+'</p>');
					body.append('<p><label>Flete</label>: '+resp[i].telefono+'</p>');
					body.append('<p><label>Fecha de entrega</label>: '+resp[i].fecha_entrega+'</p>');
					body.append('<hr>');		
				}
				body.find('p').addClass('p');
			}
		},
		complete:function()
		{
			$("#ventana").modal('show');
		},
		error:function(error,xhr,estado)
		{
			alert(error+' '+estado+' '+estado);
		}
	})
}