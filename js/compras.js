$(document).on('ready',function()
{
	btnCompras=$('.btnCompras');
	$('#modal_compras').modal({
		keyboard:false,
	});
	btnCompras.on('click',comprar);
});//fin del documento
function comprar()
{
	$('#modal_compras').modal('show');
}