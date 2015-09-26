$(document).on('ready',function()
{
	var valor;
	$("#modalConfir").modal
	({
		keyboard:true,
		backdrop:false,
		show:false
	});
	if($('#frmDestino').data('ban')=='1')
		valor = false;
	else
		valor = true;
		$('#frmDestino').find('input,button').attr('disabled',valor);
	if($('#frmPedido').data('ban')=='1')
		$('#frmPedido').find('input,button,select').attr('disabled',true);
	btnAddPedido=$("#btnAddPedido");
	btnAddPedido.on('click',addPedido);
	$(".btnAddDestino").on('click',addDestino);
	$("#otroDestino").on('click',function(){
		$('#frmDestino').find('input,button').val('');
		$('#modalConfir').modal('hide');
	});
	$('.destino').on('click',function(){
		var id_destino=$(this).data('id');
		var ruta=$(this).data('ruta');
		$("#frmDestino").find(':text').each(function(){
			$(this).val('');
		})
		getDestino(id_destino,ruta);
	})

});
function getDestino(id,ruta)
{
	$.ajax({
		url:ruta,
		beforeSend:function(){

		},
		type:'post',
		data:{id_destino:id},
		dataType:'json',
		success:function(resp)
		{
			if(!jQuery.isEmptyObject(resp))
			{
				$('#estado').val(resp[0].estado);
				$('#ciudad').val(resp[0].ciudad);
				$('#telefono').val(resp[0].telefono);
				$('#lugar').val(resp[0].lugar);
			}
			else
				alert(resp)
		},
		error:function(xhr,error,estado)
		{
			alert(xhr,error,estado);
		},
		complete:function()
		{

		}
	})
}
function addPedido()
{
	var ruta=$("#frmPedido").data('ruta');
	$.ajax({
		url:ruta,
		beforeSend:function()
		{
			$("#btnAddPedido").attr('disabled',true);
		},
		type:'post',
		data:$("#frmPedido").serialize(),
		dataType:'json',
		success:function(resp)
		{
			if(resp.validacion)
				if(resp.ban>0)
				{
					$("#frmPedido").find('input,button,select').attr('disabled',true);
					$("#frmDestino").find('input,button,select').attr('disabled',false);
				}
				else 
					alert('No se pudo insertar');
			else
			{
				$("#btnAddPedido").attr('disabled',false);
				alert('falta algun dato');
			}
		},
		error:function(xhr,error,estado)
		{
			alert(xhr+" "+error+" "+estado);
		},
		complete:function(xhr)
		{
			
		}
	});//ajax
}
function addDestino()
{
	var ruta=$("#frmDestino").data('ruta');
	$("#modalConfir").modal
	({
		keyboard:true,
		backdrop:false,
		show:false
	});
	$.ajax({
		url:ruta,
		beforeSend:function()
		{
			$("#btnAddDestino").attr('disabled',true);
		},
		type:'post',
		data:$("#frmDestino").serialize(),
		dataType:'json',
		success:function(resp)
		{
			if(resp.validacion)
			{
				if(resp.ban==1 || resp.ban=='1')
				{
					$('#modalConfir').modal('show');
				}
				else
					if(resp.ban==2 || resp.ban=='2')
						$('#modalConfir').modal('show');
			}
			else
			{
				alert('Faltan datos');
			}
		},
		error:function(xhr,error,estado)
		{
			alert(xhr+' '+error+' '+estado);
		},
		complete:function()
		{
			$("#btnAddDestino").attr('disabled',false);
		}
	});
}