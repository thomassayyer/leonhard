// Global functions //

/**
 * Convertit les caractères spéciaux en entités HTML. Permet de lutter contre
 * la faille XSS.
 *
 * @see https://fr.wikipedia.org/wiki/Cross-site_scripting
 * 
 * @param {String} text Texte à convertir.
 * 
 * @return {String} Texte convertit.
 */
function escapeHtml(text)
{
	var map = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#039;'
	};

	return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// AJAX setup //

$.ajaxSetup({
	url: 'app/controllers/AjaxHandler.php',
	cache: false,
	headers: {
        'X-CSRF-Token': $('meta[name="token"]').attr('content')
    },
	error: function(xhr, status, error)
	{
		console.log({
			'xhr': xhr,
			'status': status,
			'error': error
		});
	}
});