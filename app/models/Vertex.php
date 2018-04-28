<?php

namespace App\Models;

/**
 * Représente un sommet.
 *
 * @version 1.0
 */
class Vertex extends Model {

	/**
	 * Liste des attributs disponibles en écriture lors de l'instancation du     
	 * modèle.
	 *
	 * @var array
	 */
	protected $fillable = [
		'x',
		'y',
	];

}
