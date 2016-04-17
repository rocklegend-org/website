$(function(){
	$(document).on('click', '.comments-module input[type="submit"]', function(e)
	{
		if($(this).parent().find('textarea').val() != '')
		{
			$(this).attr('disabled', 'disabled');
			$(this).css('cursor', 'wait');

			$(this).parents('form').submit();
		}
		
		return false;
	});

	$(document).on('focus', '.comment-options textarea', function(){
		if(typeof(RL) !== 'undefined')
		{
			RL.typing = true;
		}
	});
	$(document).on('blur', '.comment-options textarea', function(){
		if(typeof(RL) !== 'undefined')
		{
			RL.typing = false;
		}
	});

	$(document).on('click', '.comments-pagination a', function(e)
	{
		e.preventDefault();

		var url = ($(this).attr('href')).replace('#','');
		var $container = $(this).parents('.comments-module');
		var comment = $('textarea[name="comment"]').val();

		$.post(url, { comment: comment, _token: csrf }, function(data)
		{
			$container.replaceWith(data);
			rl.initializeAjaxForms();
		});
	});

	$(document).on('click', 'a.comment-reply', function(e){
		e.preventDefault();

		var url = $(this).attr('href');
		var track_id = $(this).parent().data('track-id');
		var replyHtml = $('<b>Reply to comment</b><textarea></textarea><a href="#">Send reply</a>');

		$(this).parent().append(replyHtml);
		$(this).parent().find('a[href="#"]').on('click', function(e){
			e.preventDefault();
			var text = $(this).parent().find('textarea').val();

			if(text != ''){
				$(this).parent().find('a[href="#"]').remove();
				$.post(url, { reply: text, _token: csrf }, function(data){
					appendTrackComment(data);
				});
			}
		});

		$(this).remove();
	});
});

/**
 * accepts a comment object and appends it to the comment area
 */
function appendTrackComment(data)
{
	var $container = $('.comments-module[data-track-id="'+data.track_id+'"]');

	$.post('/track/comments/'+data.track_id, { _token: csrf },  function(data)
	{
		$container.replaceWith(data);

		rl.initializeAjaxForms();
	});
}