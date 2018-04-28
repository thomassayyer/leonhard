<?php

namespace App\Controllers;

use App\Converters\StringConverter;

if (session_id() === '')
{
	session_start();
}

// Inclusion de l'autoloader (auto-chargement des classes).
require __DIR__ . '/../../core/autoload.php';

/**
 * S'occupe de la gestion des requêtes AJAX.
 * 
 * @version 1.0
 */
class AjaxHandler {

	/**
	 * Paramètres de la requête HTTP.
	 * 
	 * @var array
	 */
	private $request;

	/**
	 * Méthode de la requête HTTP (POST, GET).
	 * 
	 * @var string
	 */
	private $method;

	/**
	 * Construit un manager capable de traiter les requêtes AJAX (XHR).
	 * 
	 * @param array  $request Paramètres de la requête HTTP.
	 * @param string $method  Méthode de la requête HTTP (POST, GET, ...).
	 */
	public function __construct(array $request, $method)
	{
		$this->request = $request;
		$this->method  = $method;
	}

	/**
	 * Détermine si la requête à traiter est une requête AJAX.
	 * 
	 * @return boolean Vrai si la requête est une requête AJAX; faux sinon.
	 */
	private function isAjax()
	{
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	/**
	 * Détermine si le token contre la faille CSRF de la requête à traiter est
	 * valide.
	 *
	 * @see https://fr.wikipedia.org/wiki/Cross-Site_Request_Forgery
	 *
	 * @return boolean Vrai si le token est valide; faux sinon.
	 */
	private function validToken()
	{
		$headers = apache_request_headers();

		if (!isset($headers['X-CSRF-Token']))
		{
			return false;
		}

		return $_SESSION['token'] == $headers['X-CSRF-Token'];
	}

	/**
	 * Traite la requête AJAX en appelant la méthode adéquate.
	 */
	public function handle()
	{
		if (!$this->isAjax())
		{
			http_response_code(405);
			die;
		}

		if (!$this->validToken())
		{
			http_response_code(403);
			die;
		}

		$action = strtolower($this->method) . StringConverter::snakeToPascal($this->request['action']);

		unset($this->request['action']);

		$this->$action();
	}

}

switch ($_SERVER['REQUEST_METHOD'])
{
	case 'POST':
	case 'GET':
		$request = $_REQUEST;
		break;
	case 'PUT':
	case 'DELETE':
		file_get_contents('php://input', $request);
		break;
}

$handler = new AjaxHandler($request, $_SERVER['REQUEST_METHOD']);
$handler->handle();
