$(document).on('ready',function()
{
	$('#frm_envio').find('input,button').attr('disabled',true);
	btnVenta=$("#btnVenta");
	btnVenta.on('click',venta);
});
function venta()
{
	var ruta=$("#btnVenta").data('ruta');
	var entro=false;
	$.ajax({
		url:ruta,
		beforeSend:function(){

		},
		type:'post',
		data:{credito:document.frm_credito.credito.value},
		dataType:'json',
		success:function(resp)
		{
			for(i=0;i<resp.banderas.length;i++)
				if(resp.banderas[i]!=1)
					if(resp.banderas[i]!=3)
					{
						entro=true;
						$("#lista-productos-exists").append('<li>'+resp.banderas[i]+'</li>')
						$("#panelExistencias").css('display','inline-block');
					}
					else
						alert('esa venta expiro, realizela de nuevo. si continua el error avise al proveedor')
				else
					$('#frm_envio').find('input,button').attr('disabled',false);
		},
		error:function(xhr,error,estado)
		{
			alert(xhr+" "+error+" "+estado);
		},
		complete:function(argument) 
		{
			
		}
	})
}