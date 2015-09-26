$(document).on('ready',function()
{
	if(!$('#frmDestino').data('ban'))
		$('#frmDestino').find('input,button').attr('disabled',true);
});