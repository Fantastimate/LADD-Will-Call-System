$(function()
{
	$(".container .actions").corner();
	
	$(".container .actions .confirm a").click(function(){
		$('form[name="splitform"]').submit();
		return false;
	});
	
	$(".ticket.unclaimed .action").delegate("input[type='radio']", "click", function()
	{
		if($("input[checked]",$(this).parent()).val() == 'split')
		{
			$(".input input[type='text']", $(this).parent().parent()).each(function(index)
			{
				$(this).css({color:'#999'});
				$(this).attr("disabled", false);
				switch(index)
				{
					case 0:
						$(this).val($(this).attr('placeholder'));
						break;
					
					case 1:
						$(this).val($(this).attr('placeholder'));
						break;
				}
			});
			
			$(".input", $(this).parent().parent()).fadeIn();
		}
		else
		{
			$(".input input[type='text']", $(this).parent().parent()).each(function(index)
			{
				$(this).attr("disabled", true);
			});
			
			$(".input", $(this).parent().parent()).fadeOut();
		}
	})
	
	$(".ticket.unclaimed .input").delegate("input[type='text']", "focus", function()
	{
		if($(this).val() == $(this).attr('placeholder'))
		{
			$(this).val('');
			$(this).css({color:'#000'});
		}
		
	})
});