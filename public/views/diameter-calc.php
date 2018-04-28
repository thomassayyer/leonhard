<header id="app_header" class="bg-white">

	<h1>Leonhard</h1><hr>

</header>

<section id="home_section">
	
	<h2 class="section-title">Calcul du diamètre d'un graphe</h2>
	<hr class="separator">
	<p class="section-subtitle">
		Le calcul du diamètre nécessite la matrice adjacente du graphe non-orienté. Il est possible de la renseigner ci-après en précisant le nombre de sommets ou d'importer un fichier CSV.
	</p>
	<a class="btn-rounded block-center page-scroll" href="#calc_section">C'EST PARTI !</a>

</section>

<section id="calc_section">

	<h2 class="section-title">Que voulez-vous faire ?</h2>
	<hr class="separator">
	<p class="section-subtitle">
		Le remplissage de la matrice d'adjacence est limité à 6 sommets et l'import limité aux fichiers de moins de 50 Mo. Le graphe ci-dessous est la représentation de la matrice d'adjacence (importée ou remplie).
	</p>

	<div class="container-fluid">
		
		<div class="row">
			
			<div class="col-md-4">

				<h3 class="section-subtitle">Remplir la matrice d'adjacence</h3>
				
				<div id="matrix_table">
					
					<table class="table">

						<thead>
							<tr>
								<th></th>
								<th>1</th>
								<th>2</th>
								<th>3</th>
							</tr>
						</thead>
						
						<tbody>
							<tr data-row="1">
								<td class="index">1</td>
								<td contenteditable data-column="1"></td>
								<td contenteditable data-column="2">1</td>
								<td contenteditable data-column="3">1</td>
							</tr>
							<tr data-row="2">
								<td class="index">2</td>
								<td contenteditable data-column="1">1</td>
								<td contenteditable data-column="2"></td>
								<td contenteditable data-column="3"></td>
							</tr>
							<tr data-row="3">
								<td class="index">3</td>
								<td contenteditable data-column="1">1</td>
								<td contenteditable data-column="2"></td>
								<td contenteditable data-column="3"></td>
							</tr>
						</tbody>

					</table>

				</div>

				<div id="matrix_size_buttons">

					<a class="btn btn-link btn-minus"><i class="fa fa-minus"></i></a>
					<span class="size">3</span>
					<a class="btn btn-link btn-plus"><i class="fa fa-plus"></i></a>

				</div>

			</div>

			<div class="col-md-4">
				
				<div id="graph_container"></div>

			</div>

			<div class="col-md-4">

				<div class="row">

					<div class="col-md-12">

						<h3 class="section-subtitle">Importer la matrice d'adjacence</h3>

						<div id="import_input_group" class="input-group">
							
							<label class="btn btn-file">
									
								<i class="fa fa-upload fa-3x"></i>
								<input type="file" class="sr-only">

							</label>

							<label>Importer un fichier CSV</label>

						</div>

					</div>

					<div class="col-md-12">

						<h3 id="diameter_calc_subtitle" class="section-subtitle">Calculer le diamètre</h3>

						<a id="calc_button" class="btn-rounded block-center page-scroll">CALCULER !</a>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<footer id="app_footer" class="bg-white">
	
	Réalisé avec <i class="fa fa-heart"></i> par <strong>Jérémie</strong>, <strong>Margaux</strong> et <strong>Thomas</strong> !

</footer>