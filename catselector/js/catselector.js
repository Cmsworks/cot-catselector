function catselector_changeselect(obj, area, name, userrigths)
{
	while($(obj).next('select[name="'+name+'"]').length)
	{
		$(obj).next('select[name="'+name+'"]').remove();
	}
	$.ajax
	({
		url: 'index.php?r=catselector&area='+area+'&userrigths='+userrigths+'&c=' + $(obj).val(),
		beforeSend: function() {

		},
		success: function(data)
		{
			if(data)
			{
				var optHtml = '';
				optHtml = '<option value="">---</option>';
				for (var i = 0; i < data.length; i++) {
					optHtml += '<option value="' + data[i]["id"] + '">' + data[i]["title"] + '</option>';
				}

				if(optHtml > '')
				{
					$(obj).after('<select name="'+name+'" onChange="catselector_changeselect(this, \''+area+'\', \''+name+'\', \''+userrigths+'\');">' + optHtml + '</select>');
				}
			}
		} 
	});		
}