var AutoCompleteStatus = {Open:'1', Closed:'2'};
var AutoComplete       = { Services:{}, 
                          Context:null, 
                          Input:null,
                          Status:AutoCompleteStatus.Closed, 
                          Keys:null,
                          MinLength: 2};
AutoComplete.Services.Search = './application/services/LiveSearch.php';
AutoComplete.Keys = {
		UP: 38,
		DOWN: 40,
		DEL: 46,
		TAB: 9,
		RETURN: 13,
		ESC: 27,
		COMMA: 188,
		PAGEUP: 33,
		PAGEDOWN: 34,
		BACKSPACE: 8
};
	
AutoComplete.Open = function()
{
	if(AutoComplete.Status != AutoCompleteStatus.Open)
	{
		AutoComplete.Input.unbind('focus', AutoComplete.Focus);
		
		AutoComplete.Status = AutoCompleteStatus.Open;
		AutoComplete.Context.show();
	
		$('body').bind('keyup', AutoComplete.WhileOpenKeyUp);
		$('body').bind('mouseup', AutoComplete.WhileOpenMouseUp);
	}
}

AutoComplete.WhileOpenKeyUp = function(event)
{
	if(AutoComplete.Input.val().length < AutoComplete.MinLength)
	{
		AutoComplete.Close(false);
		return;
	}
	
	if (event.keyCode == AutoComplete.Keys.ESC)
	{
		$('body').unbind('keyup', this);
		AutoComplete.Close(true);
	}
}

AutoComplete.WhileOpenMouseUp = function(event)
{
	if($(event.target).attr('data-context') != 'live-search-element')
	{
		AutoComplete.Close(true);
	}
}

AutoComplete.Close = function(blur)
{
	AutoComplete.Status = AutoCompleteStatus.Closed;
	
	if(blur)
	{
		$('body').unbind('keyup', AutoComplete.WhileOpenKeyUp);
		$('body').unbind('mouseup', AutoComplete.WhileOpenMouseUp);
		
		AutoComplete.Input.blur();
		AutoComplete.Input.val(AutoComplete.Input.attr('placeholder'));
		AutoComplete.Input.bind('focus', AutoComplete.Focus);
	}
	
	AutoComplete.Context.hide();
	
}

AutoComplete.Focus = function()
{
	AutoComplete.Input.val('');
}


$(function()
{
	AutoComplete.Context = $("#live-search .live-search-results");
	AutoComplete.Input = $("#live-search input");
	
	AutoComplete.Close(true);
	
	$('#live-search input').autocomplete({
		minLength: AutoComplete.MinLength,
		source: LiveSearchWillSearch
		});
})

function LiveSearchWillSearch(request, response)
{
	$.get(AutoComplete.Services.Search,
		  {q:request.term},
		  LiveSearchWillShowResponse);
}

function LiveSearchWillShowResponse(data)
{
	if(data.length > 0)
	{
		LiveSearchProcessTickets(data);
	}
	else
	{
		LiveSearchProcessNoResults();
	}
}

function LiveSearchProcessTickets(data)
{
	
	var templateUnclaimed = $("#template-live-search-result-unclaimed").text().toString();
	var templateClaimed = $("#template-live-search-result-claimed").text().toString();
	
	AutoComplete.Context.html('');
	
	if(data.length)
	{
		data.forEach(function(item)
		{
			if(item.claimed)
			{
				AutoComplete.Context.append(Mustache.to_html(templateClaimed, item));
			}
			else
			{
				item.querystring  = LiveSearchQueryString(item);
				item.split_status = item.total > 1 ? 'enabled' : 'disabled';
				AutoComplete.Context.append(Mustache.to_html(templateUnclaimed, item));
			}
			
		})
	}
	
	AutoComplete.Open();
}

function LiveSearchQueryString(ticket)
{
	
	var result = [];
	result.push("numtix="+ticket.total);

	for(var i = 0; i < ticket.ids.length; i++)
	{
		result.push("id["+i+"]="+ticket.ids[i]);
	}
	
	return result.join('&');
}


function LiveSearchProcessNoResults()
{
	AutoComplete.Context.html('');
}