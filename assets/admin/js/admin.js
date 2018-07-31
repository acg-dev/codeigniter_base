$(document).ready(function(){
	$('#usmenu').find('a').each(function(){
		if(window.location.href.indexOf($(this).attr('href').replace(base_url, '')) > -1 && $(this).attr('href').replace(base_url, '').split('/').length == window.location.href.replace(base_url, '').split('/').length){
			$(this).addClass('act');
			if($(this).parents('div').hasClass('group'))
				$(this).parents('div.group').addClass('act');
		}
	});

	$('#usmenu .group a').click(function(){
		var group = $(this).parent('.group');
		if(group.hasClass('act')){
			group.find('ul').slideUp(200, function(){group.removeClass('act')});
		}else{
			group.find('ul').slideDown(200, function(){group.addClass('act')});
		}
	});

	$('.menu-bar').on('click', function(){
		if($(this).parents('.menu').hasClass('open')){
			$(this).parents('.menu').removeClass('open');
			$('.body-frame').removeClass('open');
		}else{
			$(this).parents('.menu').addClass('open');
			$('.body-frame').addClass('open');
		}
	});
});