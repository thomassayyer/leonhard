/**
 * Dernier chiffre affiché dans la matrice.
 * 
 * @type {Integer}
 */
var lastIndex = 3;

/**
 * Instance de sigma pour le conteneur #graph.
 *
 * @type {Object}
 */
var s;

/**
 * Objet d'écoute des événements liés au déplacement des sommets du graphe.
 *
 * @type {Object}
 */
var dragListener;

$(function()
{
	s = new sigma({
		graph: {
			nodes: [
				{
					id: 'n1',
					label: '1',
					x: Math.random(),
					y: Math.random(),
					size: 1
				},
				{
					id: 'n2',
					label: '2',
					x: Math.random(),
					y: Math.random(),
					size: 1
				},
				{
					id: 'n3',
					label: '3',
					x: Math.random(),
					y: Math.random(),
					size: 1
				}
			],
			edges: [
				{
					id: 'e12',
					source: 'n1',
					target: 'n2'
				},
				{
					id: 'e13',
					source: 'n1',
					target: 'n3'
				},
				{
					id: 'e21',
					source: 'n2',
					target: 'n1'
				},
				{
					id: 'e31',
					source: 'n3',
					target: 'n1'
				}
			]
		},
		container: 'graph_container'
	});

	dragListener = new sigma.plugins.dragNodes(s, s.renderers[0]);

	s.settings({
		defaultEdgeColor: '#FFF',
		defaultNodeColor: '#FFF',
		defaultLabelColor: '#FFF'
	});

	s.refresh();

	$('#matrix_size_buttons > .btn-minus').on('click', function()
	{
		var size = parseInt($('#matrix_size_buttons > .size').text(), 10);

		if (size > 0)
		{
			$('#matrix_size_buttons > .size').text(size - 1);

			$('#matrix_table > table > thead > tr > th:last').remove();
			$('#matrix_table > table > tbody > tr:last').remove();
			$('#matrix_table > table > tbody > tr').each(function()
			{
				$(this).find('td:last').remove();
			});

			s.graph.dropNode('n' + size);
			$('#graph_container').height($('#matrix_table').height() + 100);
			s.refresh();

			lastIndex--;
		}
	});

	$('#matrix_size_buttons > .btn-plus').on('click', function()
	{
		var size = parseInt($('#matrix_size_buttons > .size').text(), 10);

		if (size >= 6)
		{
			return;
		}

		$('#matrix_size_buttons > .size').text(size + 1);

		if ($('#matrix_table td').length > 0)
		{
			lastIndex++;
		}
		else
		{
			lastIndex = 1;
		}

		$('#matrix_table > table > thead > tr').append('<th>' + lastIndex + '</th>');
		$('#matrix_table > table > tbody').append(
			'<tr data-row="' + lastIndex + '">' +
				'<td class="index">' + lastIndex + '</td>' +
			'</tr>'
		);
		$('#matrix_table > table > tbody > tr:not(:last)').append('<td contenteditable data-column="' + (size + 1) + '"></td>');

		for (var i = 1, length = (size + 1); i <= length; i++)
		{
			$('#matrix_table > table > tbody > tr:last').append('<td contenteditable data-column="' + i + '"></td>');
		}

		$('#matrix_table > table > tbody td:not(.index)').css('border', 'solid white 1px');

		s.graph.addNode({
			id: 'n' + (size + 1),
			label: (size + 1).toString(),
			x: Math.random(),
			y: Math.random(),
			size: 1
		});

		$('#graph_container').height($('#matrix_table').height() + 100);

		s.refresh();
	});

	$(document).on('blur', '#matrix_table td', function()
	{
		var value = parseInt($(this).text(), 10);

		if (value > 0)
		{
			$(this).text(1);
		}
		else if (value < 0)
		{
			$(this).text(0);
		}
		else if (isNaN(value))
		{
			$(this).text('');
		}

		var source = parseInt($(this).closest('tr').data('row'), 10);
		var target = parseInt($(this).data('column'), 10);

		if ($(this).text() == '1')
		{
			s.graph.addEdge({
				id: 'e' + source + target,
				source: 'n' + source,
				target: 'n' + target
			});
		}
		else
		{
			s.graph.dropEdge('e' + source + target);
		}

		s.refresh();

		// On assigne la même valeur à la cellule symétrique.
		$('#matrix_table').find('tr[data-row="' + target + '"]').find('td[data-column="' + source + '"]').text($(this).text()).trigger('blur');
	});

});