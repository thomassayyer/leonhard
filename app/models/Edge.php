<?php

namespace App\Models;

/**
 * Représente une arête.
 *
 * @version 1.0
 */
class Edge extends Model {

	/**
	 * Liste des attributs disponibles en écriture lors de l'instancation du     
	 * modèle.
	 *
	 * @var array
	 */
	protected $fillable = [
		'origin',
		'destination',
	];

}
