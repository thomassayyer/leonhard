$(function()
{
	$('a.page-scroll').on('click', function(e)
	{
		$('html,body').animate({
			scrollTop: $($(this).attr('href')).offset().top
		}, 500);

		e.preventDefault();
	});
});