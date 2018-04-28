<?php

namespace App\Controllers;

/**
 * Classe mère de tous les contrôleurs.
 * 
 * @version 1.0
 */
abstract class Controller {

	/**
	 * Paramètres de la requête HHTP
	 * 
	 * @var array
	 */
	protected $request;

	/**
	 * Construit une nouvelle instance de la classe Controller.
	 * 
	 * @param array $request
	 */
	public function __construct(array $request)
	{
		$this->request = $request;
	}

	/**
	 * Permet d'inclure (d'afficher) une vue.
	 * 
	 * @param string Nom de la vue à inclure (elle se trouve dans le dossier
	 * 				 "public/views").
	 * @param array  Ensemble des variables à inclure dans la vue.
	 */
	protected function display($view, array $variables = [])
	{
		foreach ($variables as $name => $value)
		{
			$$name = $value;
		}

		include __DIR__ . "/../../public/views/$view.php";
	}

	/**
	 * Affiche une réponse à l'écran et définie un code HTTP de retour.
	 * 
	 * @param string  $content    Contenu de la réponse à afficher.
	 * @param integer $statusCode Code retour HTTP.
	 */
	protected function response($content, $statusCode = 200)
	{
		http_response_code($statusCode);
		echo "$content";

		if ($statusCode == 500)
		{
			die;
		}
	}

	/**
	 * Procède à la validation des paramètres de la requête HTTP. Si un des
	 * champs n'est pas valide, affiche un message d'erreur à l'écran en
	 * spécifiant le code HTTP 400 Bad Request.
	 * 
	 * @param array $rulesPerField Ensemble des règles par champ de la requête.
	 */
	protected function validate(array $rulesPerField)
	{
		$errors = [];

		foreach ($rulesPerField as $field => $rules)
		{
			foreach ($rules as $rule => $value)
			{
				unset($message);

				if (is_array($value) && array_key_exists('message', $value))
				{
					$message = $value['message'];
					unset($value['message']);

					if (count($value) == 1)
					{
						$value = $value[0];
					}
				}

				switch ($rule)
				{
					case 'required':
						if ($value === true)
						{
							if (isset($this->request[$field]) && empty($this->request[$field]))
							{
								$errors[$field][] = isset($message) ? $message : "Veuillez renseigner ce champ !";
							}
						}
						break;
					case 'max':
						// Si la valeur est une chaine de caractères ...
						if (intval($this->request[$field]) == 0)
						{
							if (strlen($this->request[$field]) > $value)
							{
								$errors[$field][] = isset($message) ? $message : "La valeur du champ doit être d'une longueur maximale de $value caractères !";
							}
						}
						else
						{
							if ($this->request[$field] > $value)
							{
								$errors[$field][] = isset($message) ? $message : "La valeur du champ doit être d'une valeur maximale de $value !";
							}
						}
						break;
					case 'min':
						// Si la valeur est une chaine de caractères ...
						if (intval($this->request[$field]) == 0)
						{
							if (strlen($this->request[$field]) < $value)
							{
								$errors[$field][] = isset($message) ? $message : "La valeur du champ doit être d'une longueur d'au moins $value caractères !";
							}
						}
						else
						{
							if ($this->request[$field] < $value)
							{
								$errors[$field][] = isset($message) ? $message : "La valeur du champ doit être d'au moins $value !";
							}
						}
						break;
					case 'equals':
						if ($this->request[$field] != $this->request[$value])
						{
							$errors[$field][] = isset($message) ? $message : "Les champs $field et $value ne correspondent pas !";
						}
						break;
					case 'in':
						if ($value instanceof \App\Repositories\Repository)
						{
							if ($value->find($this->request[$field]) == null)
							{
								$errors[$field][] = isset($message) ? $message : "La valeur est invalide !";
							}
						}
						else if (!in_array($this->request[$field], $value))
						{
							$errors[$field][] = isset($message) ? $message : "La valeur est invalide !";
						}
						break;
					case 'format':
						switch ($value)
						{
							case 'email':
								if (!filter_var($this->request[$field], FILTER_VALIDATE_EMAIL))
								{
									$errors[$field][] = isset($message) ? $message : "{$this->request[$field]} n'est pas une adresse email valide !";
								}
								break;
							case 'd/m/Y':
								$d = \DateTime::createFromFormat($value, $this->request[$field]);
								if (!$d || $d->format($value) != $this->request[$field])
								{
									$errors[$field][] = isset($message) ? $message : "{$this->request[$field]} n'est pas au format JJ/MM/AAAA !";
								}
								break;
							default :
								$this->response("Format $value inconnu !", 500);
								break;
						}
						break;
					default:
						$this->response("Règle de saisie $rule inconnue !", 500);
						break;
				}
			}
		}

		if (!empty($errors))
		{
			$this->response(json_encode($errors), 422);
			die;
		}
	}

}