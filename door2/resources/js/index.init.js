$(function()
{
	$("#notifications-container").corner('round');
	$("#notifications-container .notification").corner('round');
	if($("#notifications-container").children().length > 0)
	{
		$("#notifications-container").fadeIn();
		
		/*setTimeout(function()
		{
			$("#notifications-container").fadeOut();
			
		}, 5000);
		*/
	}
})