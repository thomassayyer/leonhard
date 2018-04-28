<?php

namespace App\Converters;

/**
 * Effectue les différentes conversions de chaines de caractères.
 *
 * @version 1.0
 */
class StringConverter
{
	/**
	 * Convertie une chaine de caractère en snake_case (chaque mot séparé par un
	 * "_") en camelCase (première lettre en minuscule et chaque nouveau mot
	 * avec la première lettre en majuscule. Aucun caractère particulier !).
	 * 
	 * @param string $str Chaine de caractères snake_case à convertir.
	 * 
	 * @return string Chaine de caractères au format camelCase.
	 */
	public static function snakeToCamel($str)
	{
		return lcfirst(self::snakeToPascal($str));
	}

	/**
	 * Convertie une chaine de caractère en snake_case (chaque mot séparé par un
	 * "_") en PascalCase (chaque nouveau mot, y compris le premier mot, avec la
	 * première lettre en majuscule. Aucun caractère particulier !).
	 * 
	 * @param string $str Chaine de caractères snake_case à convertir.
	 * 
	 * @return string Chaine de caractères au format PascalCase.
	 */
	public static function snakeToPascal($str)
	{
		$result = '';

		$aStr = explode('_', $str);

		foreach ($aStr as $s)
		{
			$result .= ucfirst($s);
		}

		return $result;
	}

	/**
	 * Convertie une chaine de caractère en camelCase (première lettre en
	 * minuscule et chaque nouveau mot avec la première lettre en majuscule.
	 * Aucun caractère particulier !) en snake_case (chaque mot séparé par un
	 * "_").
	 * 
	 * @param string $str Chaine de caractères camelCase à convertir.
	 * 
	 * @return string Chaine de caractères au format snake_case.
	 */
	public static function camelToSnake($str)
	{
		return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $str));
	}

	/**
	 * Convertie une chaine de caractère en PascalCase (chaque nouveau mot, y
	 * compris le premier mot, avec la première lettre en majuscule. Aucun
	 * caractère particulier !) en snake_case (chaque mot séparé par un "_").
	 * 
	 * @param string $str Chaine de caractères camelCase à convertir.
	 * 
	 * @return string Chaine de caractères au format snake_case.
	 */
	public static function pascalToSnake($str)
	{
		return self::camelToSnake(lcfirst($str));
	}

	/**
	 * Convertie une chaine de caractère en la mettant au singulier.
	 * 
	 * @param string $str Chaine de caractère à convertir.
	 * 
	 * @return string Chaine de caractère au singulier.
	 */
	public static function singular($str)
	{
		// Si les deux dernières lettres sont es ...
		if (substr($str, -2) == 'es')
		{
			return substr_replace($str, '', -2);
		}

		// Si la dernière lettre est un s ...
		if (substr($str, -1) == 's')
		{
			return substr_replace($str, '', -1);
		}

		return $str;
	}

	/**
	 * Convertie une chaine de caractère en la mettant au pluriel.
	 * 
	 * @param string $str Chaine de caractère à convertir.
	 * 
	 * @return string Chaine de caractère au pluriel.
	 */
	public static function plural($str)
	{
		// Si la dernière lettre est un x ...
		if (substr($str, -1) == 'x')
		{
			return $str . 'es';
		}

		// Si la dernière lettre est un s ...
		if (substr($str, -1) == 's')
		{
			return $str;
		}

		return $str . 's';
	}

	/**
	 * Recherche et supprime les commentaires d'un fichier JSON.
	 * 
	 * @param string $json Chaine de caractère au format JSON à convertir.
	 * 
	 * @return string Chaine de caractère JSON convertie.
	 */
	public static function cleanJson($json)
	{
		return preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t](//).*)#", '', $json); 
	}
}
