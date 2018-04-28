<?php

namespace App\Models;

use App\Converters\StringConverter;

/**
 * Classe mère de tous les modèles.
 *
 * @version 1.0
 */
abstract class Model implements \JsonSerializable {

	/**
	 * Liste des attributs disponibles en écriture lors de l'instancation du     
	 * modèle.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * Liste des attributs cachés lors des exports.
	 * 
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Dictionnaire contenant l'nensemble des attributs ayant subi une mutation.
	 * 
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Construit une nouvelle instance de la classe Model.
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes)
	{
		if (!empty($attributes))
		{
			$this->hydrate($attributes);
		}
	}

	/**
	 * Méthode magique appelée à chaque mutation d'un attribut.
	 * 
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value)
	{
		$setter = "set" . ucfirst($name);

		if (method_exists($this, $setter))
		{
			$this->$setter($value);
		} 
		else
		{
			$this->attributes[$name] = $value;
		}
	}

	/**
	 * Méthode magique appelée à chaque lecture d'un attribut.
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		$getter = "get" . ucfirst($name)

		if (method_exists($this, $getter))
		{
			return $this->$getter();
		}

		return $this->attributes[$name];
	}

	/**
	 * Hydrate le modèle avec les attributs fournis en paramètre (tableau de
	 * la forme [name => value]).
	 * 
	 * @param array $attributes
	 */
	private function hydrate(array $attributes)
	{
		foreach ($attributes as $name => $value)
		{
			$setter = 'set' . StringConverter::snakeToPascal($name);

			// si un setter existe.
			if (method_exists($this, $setter))
			{
				$this->$setter($value);
				continue;
			}

			if (in_array($name, $this->fillable))
			{
				$this->attributes[$name] = $value;
			}
		}
	}

	/**
	 * Transforme l'objet courant en tableau.
	 *
	 * @param boolean $ignoreHidden
	 * @return \App\Models\Model
	 */
	public function toArray($ignoreHidden = true)
	{
		$array = [];

		foreach ($this->attributes as $name => $value)
		{
			if (!in_array($this->hidden, $name))
			{
				$array[$name] = $value;
			}
		}

		return $array;
	}

	/**
	 * Méthode appelée lors de la conversion de l'objet courant au format JSON.
	 * 
	 * @return string La représentation JSON de l'objet courant.
	 */
	public function jsonSerialize()
	{
		return $this->toArray(true);
	}

	/**
	 * Appelée lors de la conversion du modèle en chaine de caractères
	 * (ex.: echo $MODEL_INSTANCE).
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return json_encode($this, JSON_FORCE_OBJECT);
	}

}
