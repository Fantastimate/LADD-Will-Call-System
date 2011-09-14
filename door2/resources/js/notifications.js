$(function(){
	$('.ticket').delegate(".notification", "mouseover", notificationShow)
	            .delegate(".notification", "mouseout", notificationHide)
	            .delegate("a.notification", "click", notificationClick)
})

function notificationHide()
{
	$(".infoBox").fadeOut();
}

function notificationShow()
{
	var context = $(".infoBox");
	var offset  = $(this).offset();
	var title   = $(this).html();
	var message = $(".notification>li", $(this).parent().parent().parent()).html();
	
	$('h3', context).html(title);
	$('p', context).html(message);
	
	context.css({"top":offset.top - context.height()-10, "left":offset.left - 142}).fadeIn();
}

function notificationClick()
{
	return false;
}